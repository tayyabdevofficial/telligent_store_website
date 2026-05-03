<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Stripe\Checkout\Session;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\StripeClient;
use Stripe\Webhook;
use UnexpectedValueException;

class StripeCheckoutService
{
    public function createCheckoutSession(
        Order $order,
        Payment $payment,
        string $lineItemName,
        ?string $lineItemDescription = null,
    ): Session {
        if (! config('services.stripe.secret')) {
            throw ValidationException::withMessages([
                'stripe' => 'Stripe is not configured yet. Add STRIPE_SECRET_KEY and STRIPE_PUBLISHABLE_KEY to your environment.',
            ]);
        }

        $productData = [
            'name' => $lineItemName,
        ];

        if (filled($lineItemDescription)) {
            $productData['description'] = $lineItemDescription;
        }

        return $this->client()->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => route('checkout.success', [$order, $order->guest_token]).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', [$order, $order->guest_token]),
            'customer_creation' => 'always',
            'customer_email' => $order->customer_email,
            'payment_intent_data' => [
                'metadata' => [
                    'order_id' => (string) $order->id,
                    'payment_id' => (string) $payment->id,
                ],
            ],
            'metadata' => [
                'order_id' => (string) $order->id,
                'payment_id' => (string) $payment->id,
                'package_id' => (string) $order->service_package_id,
            ],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => strtolower($order->currency),
                    'unit_amount' => (int) round($order->total * 100),
                    'product_data' => $productData,
                ],
            ]],
        ]);
    }

    public function syncOrderFromSession(Order $order, string $sessionId): void
    {
        if (! $sessionId) {
            return;
        }

        $session = $this->retrieveCheckoutSession($sessionId);

        if ((string) data_get($session, 'metadata.order_id') !== (string) $order->id) {
            return;
        }

        $payment = $order->payments()->latest()->first();

        if (! $payment) {
            return;
        }

        $this->applySessionStatus($order, $payment, $session->toArray());
    }

    public function handleWebhook(string $payload, ?string $signature): void
    {
        $event = $this->parseWebhookEvent($payload, $signature);

        if (! in_array($event->type, [
            'checkout.session.completed',
            'checkout.session.async_payment_succeeded',
            'checkout.session.async_payment_failed',
            'checkout.session.expired',
        ], true)) {
            return;
        }

        $webhookSession = $event->data->object->toArray();
        $sessionId = data_get($webhookSession, 'id');
        $orderId = data_get($webhookSession, 'metadata.order_id');

        if (! $orderId || ! $sessionId) {
            return;
        }

        $session = $this->retrieveCheckoutSession($sessionId)->toArray();

        $order = Order::query()->with('payments')->find($orderId);
        $payment = $order?->payments?->sortByDesc('id')->first();

        if (! $order || ! $payment) {
            return;
        }

        $this->applySessionStatus($order, $payment, $session, $webhookSession);
    }

    protected function applySessionStatus(
        Order $order,
        Payment $payment,
        array $session,
        ?array $payloadToStore = null,
    ): void {
        $sessionStatus = data_get($session, 'payment_status');
        $paymentMethod = $this->resolvePaymentMethodLabel($session);
        $payloadToStore ??= $session;
        $status = match ($sessionStatus) {
            'paid' => PaymentStatus::Paid,
            'unpaid', 'no_payment_required' => PaymentStatus::Pending,
            default => data_get($session, 'status') === 'expired'
                ? PaymentStatus::Expired
                : PaymentStatus::Failed,
        };

        $orderStatus = match ($status) {
            PaymentStatus::Paid => OrderStatus::Paid,
            PaymentStatus::Pending => OrderStatus::AwaitingPayment,
            PaymentStatus::Expired => OrderStatus::Expired,
            PaymentStatus::Failed => OrderStatus::Failed,
            PaymentStatus::Refunded => OrderStatus::Refunded,
        };

        DB::transaction(function () use ($order, $payment, $session, $status, $orderStatus, $paymentMethod, $payloadToStore) {
            $payment->forceFill([
                'provider' => $paymentMethod,
                'provider_session_id' => data_get($session, 'id'),
                'provider_payment_id' => $this->resolvePaymentIntentId($session),
                'status' => $status,
                'payload' => $payloadToStore,
                'paid_at' => $status === PaymentStatus::Paid ? now() : $payment->paid_at,
            ])->save();

            $order->forceFill([
                'status' => $orderStatus,
            ])->save();
        });
    }

    protected function parseWebhookEvent(string $payload, ?string $signature): Event
    {
        $secret = config('services.stripe.webhook_secret');

        if ($secret && $signature) {
            try {
                return Webhook::constructEvent($payload, $signature, $secret);
            } catch (UnexpectedValueException|SignatureVerificationException) {
                abort(400, 'Invalid Stripe webhook payload.');
            }
        }

        return Event::constructFrom(json_decode($payload, true, 512, JSON_THROW_ON_ERROR));
    }

    protected function retrieveCheckoutSession(string $sessionId): Session
    {
        return $this->client()->checkout->sessions->retrieve($sessionId, [
            'expand' => [
                'payment_intent.latest_charge.payment_method_details',
            ],
        ]);
    }

    protected function resolvePaymentMethodLabel(array $session): string
    {
        $paymentMethodType = data_get($session, 'payment_intent.latest_charge.payment_method_details.type')
            ?: data_get($session, 'payment_method_types.0');

        return match ($paymentMethodType) {
            'cashapp' => 'cash_app',
            'card' => 'card',
            'link' => 'link',
            'paypal' => 'paypal',
            'us_bank_account' => 'bank_account',
            null, '' => 'stripe',
            default => (string) $paymentMethodType,
        };
    }

    protected function resolvePaymentIntentId(array $session): ?string
    {
        $paymentIntent = data_get($session, 'payment_intent');

        if (is_array($paymentIntent)) {
            return data_get($paymentIntent, 'id');
        }

        return is_string($paymentIntent) ? $paymentIntent : null;
    }

    protected function client(): StripeClient
    {
        return new StripeClient([
            'api_key' => config('services.stripe.secret'),
            'stripe_version' => '2026-02-25.clover',
        ]);
    }
}

