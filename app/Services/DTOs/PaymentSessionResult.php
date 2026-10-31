<?php

namespace App\Services\DTOs;

class PaymentSessionResult
{
    public function __construct(
        public readonly string $redirectUrl,
        public readonly ?string $sessionId = null,
        public readonly ?string $paymentId = null,
        public readonly array $rawPayload = [],
    ) {}
}

