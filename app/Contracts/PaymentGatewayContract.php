<?php

namespace App\Contracts;

use App\Models\Order;
use App\Models\Payment;
use App\Services\DTOs\PaymentSessionResult;

interface PaymentGatewayContract
{
    /**
     * Unique identifier for the gateway (e.g. 'stripe', 'xsolla').
     */
    public function id(): string;

    /**
     * Customer-facing display name.
     */
    public function name(): string;

    /**
     * Whether the gateway is enabled in configuration (.env).
     */
    public function isEnabled(): bool;

    /**
     * Whether required API keys/credentials are present.
     */
    public function isConfigured(): bool;

    /**
     * Create a checkout session/token and generate redirect URL.
     */
    public function createCheckoutSession(
        Order $order,
        Payment $payment,
        string $lineItemName,
        ?string $lineItemDescription = null,
    ): PaymentSessionResult;

    /**
     * Optionally sync order status from session/return redirect if supported.
     */
    public function syncOrderFromSession(Order $order, string $sessionId): void;
}

