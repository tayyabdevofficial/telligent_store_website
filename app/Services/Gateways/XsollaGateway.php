<?php

namespace App\Services\Gateways;

use App\Contracts\PaymentGatewayContract;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Services\DTOs\PaymentSessionResult;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class XsollaGateway implements PaymentGatewayContract
{
    public function id(): string
    {
        return 'xsolla';
    }

    public function name(): string
    {
        return config('payments.gateways.xsolla.name', 'Xsolla');
    }

    public function isEnabled(): bool
    {
        return (bool) config('payments.gateways.xsolla.enabled', true);
    }

    public function isConfigured(): bool
    {
        return filled($this->merchantId()) &&
            filled($this->projectId()) &&
            filled($this->apiKey());
    }

    public function isSandbox(): bool
    {
        return (bool) config('payments.gateways.xsolla.sandbox', true);
    }

    public function merchantId(): ?string
    {
        return config('payments.gateways.xsolla.merchant_id') ? (string) config('payments.gateways.xsolla.merchant_id') : null;
    }

    public function projectId(): ?string
    {
        return config('payments.gateways.xsolla.project_id') ? (string) config('payments.gateways.xsolla.project_id') : null;
    }

    public function apiKey(): ?string
    {
        return config('payments.gateways.xsolla.api_key') ? (string) config('payments.gateways.xsolla.api_key') : null;
    }

    public function webhookSecret(): ?string
    {
        return config('payments.gateways.xsolla.webhook_secret') ? (string) config('payments.gateways.xsolla.webhook_secret') : null;
    }

    public function createCheckoutSession(
        Order $order,
        Payment $payment,
        string $lineItemName,
        ?string $lineItemDescription = null,
    ): PaymentSessionResult {
        if (! $this->isEnabled()) {
            throw ValidationException::withMessages([
                'payment_method' => 'Xsolla payment method is currently disabled.',
            ]);
        }

        if (! $this->isConfigured()) {
            throw ValidationException::withMessages([
                'xsolla' => 'Xsolla is not configured yet. Please configure XSOLLA_MERCHANT_ID, XSOLLA_PROJECT_ID, and XSOLLA_API_KEY in your environment.',
            ]);
        }

        $userId = $order->user_id ? (string) $order->user_id : (string) $order->guest_token;
        $returnUrl = route('checkout.success', [$order, $order->guest_token]).'?provider=xsolla';

        $user = [
            'id' => [
                'value' => $userId,
            ],
        ];

        if (filled($order->customer_email)) {
            $user['email'] = [
                'value' => (string) $order->customer_email,
            ];
        }

        if (filled($order->customer_name)) {
            $user['name'] = (string) $order->customer_name;
        }

        $settings = [
            'project_id' => (int) $this->projectId(),
            'currency' => strtoupper($order->currency ?: 'USD'),
            'return_url' => $returnUrl,
        ];

        if ($this->isSandbox()) {
            $settings['mode'] = 'sandbox';
        }

        $payload = [
            'user' => $user,
            'settings' => $settings,
            'purchase' => [
                'checkout' => [
                    'currency' => strtoupper($order->currency ?: 'USD'),
                    'amount' => (float) $order->total,
                ],
            ],
            'custom_parameters' => [
                'order_id' => (string) $order->id,
                'payment_id' => (string) $payment->id,
            ],
        ];

        $endpoint = "https://api.xsolla.com/merchant/v2/merchants/{$this->merchantId()}/token";

        $response = Http::asJson()
            ->acceptJson()
            ->withBasicAuth((string) $this->merchantId(), (string) $this->apiKey())
            ->timeout(15)
            ->post($endpoint, $payload);

        if (! $response->successful()) {
            $errorMessage = $response->json('error.message')
                ?: $response->json('message')
                ?: 'Xsolla service returned an error (HTTP '.$response->status().').';

            Log::error('Xsolla token creation failed', [
                'order_id' => $order->id,
                'status' => $response->status(),
                'response' => $response->json() ?: $response->body(),
            ]);

            throw ValidationException::withMessages([
                'payment' => 'Unable to initiate Xsolla checkout: '.$errorMessage,
            ]);
        }

        $token = (string) $response->json('token');
        $baseUrl = $this->isSandbox()
            ? 'https://sandbox-secure.xsolla.com/paystation4/'
            : 'https://secure.xsolla.com/paystation4/';

        $redirectUrl = $baseUrl.'?token='.urlencode($token);

        return new PaymentSessionResult(
            redirectUrl: $redirectUrl,
            sessionId: $token,
            paymentId: null,
            rawPayload: $response->json(),
        );
    }

    public function syncOrderFromSession(Order $order, string $sessionId): void
    {
        // Xsolla order status is updated asynchronously via webhook.
    }

    public function verifyWebhookSignature(string $rawBody, ?string $authHeader): bool
    {
        $secret = $this->webhookSecret();

        if (! $secret) {
            return false;
        }

        if (! $authHeader || ! str_starts_with($authHeader, 'Signature ')) {
            return false;
        }

        $receivedSignature = trim(substr($authHeader, 10));
        $expectedSignature = sha1($rawBody.$secret);

        return hash_equals($expectedSignature, $receivedSignature);
    }

    public function handleWebhook(string $rawBody, ?string $authHeader): Response
    {
        if (! $this->verifyWebhookSignature($rawBody, $authHeader)) {
            Log::warning('Xsolla webhook signature verification failed.');
            abort(400, 'Invalid Xsolla webhook signature.');
        }

        $data = json_decode($rawBody, true) ?: [];
        $notificationType = data_get($data, 'notification_type');

        return match ($notificationType) {
            'user_validation' => response()->noContent(204),
            'order_paid', 'payment' => $this->handlePaymentNotification($data),
            'order_canceled', 'refund' => $this->handleRefundNotification($data),
            default => response()->noContent(204),
        };
    }

    protected function handlePaymentNotification(array $payload): Response
    {
        $orderId = data_get($payload, 'custom_parameters.order_id')
            ?: data_get($payload, 'order.id');

        $paymentId = data_get($payload, 'custom_parameters.payment_id');

        $order = Order::query()->with('payments')->find($orderId);
        if (! $order) {
            Log::warning("Xsolla webhook: Order #{$orderId} not found.");

            return response()->noContent(204);
        }

        $payment = $paymentId
            ? $order->payments->firstWhere('id', (int) $paymentId)
            : $order->payments->sortByDesc('id')->first();

        if (! $payment) {
            Log::warning("Xsolla webhook: Payment for Order #{$orderId} not found.");

            return response()->noContent(204);
        }

        $transactionId = (string) (
            data_get($payload, 'transaction.id')
            ?: data_get($payload, 'order.id')
            ?: data_get($payload, 'payment.id')
            ?: 'xsolla_tx_'.now()->timestamp
        );

        DB::transaction(function () use ($order, $payment, $transactionId, $payload) {
            $payment->forceFill([
                'provider' => 'xsolla',
                'provider_payment_id' => $transactionId,
                'status' => PaymentStatus::Paid,
                'payload' => $payload,
                'paid_at' => $payment->paid_at ?? now(),
            ])->save();

            $order->forceFill([
                'status' => OrderStatus::Paid,
            ])->save();
        });

        return response()->noContent(204);
    }

    protected function handleRefundNotification(array $payload): Response
    {
        $orderId = data_get($payload, 'custom_parameters.order_id')
            ?: data_get($payload, 'order.id');

        $order = Order::query()->with('payments')->find($orderId);
        $payment = $order?->payments?->sortByDesc('id')->first();

        if ($order && $payment) {
            DB::transaction(function () use ($order, $payment, $payload) {
                $payment->forceFill([
                    'status' => PaymentStatus::Refunded,
                    'payload' => $payload,
                ])->save();

                $order->forceFill([
                    'status' => OrderStatus::Refunded,
                ])->save();
            });
        }

        return response()->noContent(204);
    }
}
