<?php

namespace App\Services\Gateways;

use App\Contracts\PaymentGatewayContract;
use App\Models\Order;
use App\Models\Payment;
use App\Services\DTOs\PaymentSessionResult;
use App\Services\StripeCheckoutService;
use Illuminate\Validation\ValidationException;

class StripeGateway implements PaymentGatewayContract
{
    public function __construct(
        protected StripeCheckoutService $stripeCheckoutService,
    ) {}

    public function id(): string
    {
        return 'stripe';
    }

    public function name(): string
    {
        return config('payments.gateways.stripe.name', 'Stripe');
    }

    public function isEnabled(): bool
    {
        return (bool) config('payments.gateways.stripe.enabled', false);
    }

    public function isConfigured(): bool
    {
        return filled(config('payments.gateways.stripe.secret', config('services.stripe.secret')));
    }

    public function createCheckoutSession(
        Order $order,
        Payment $payment,
        string $lineItemName,
        ?string $lineItemDescription = null,
    ): PaymentSessionResult {
        if (! $this->isEnabled()) {
            throw ValidationException::withMessages([
                'payment_method' => 'Stripe is currently disabled.',
            ]);
        }

        if (! $this->isConfigured()) {
            throw ValidationException::withMessages([
                'stripe' => 'Stripe is not configured yet. Add STRIPE_SECRET_KEY and STRIPE_PUBLISHABLE_KEY to your environment.',
            ]);
        }

        $session = $this->stripeCheckoutService->createCheckoutSession(
            $order,
            $payment,
            $lineItemName,
            $lineItemDescription,
        );

        return new PaymentSessionResult(
            redirectUrl: (string) $session->url,
            sessionId: (string) $session->id,
            paymentId: is_string($session->payment_intent) ? $session->payment_intent : (string) data_get($session->payment_intent, 'id'),
            rawPayload: $session->toArray(),
        );
    }

    public function syncOrderFromSession(Order $order, string $sessionId): void
    {
        $this->stripeCheckoutService->syncOrderFromSession($order, $sessionId);
    }
}

