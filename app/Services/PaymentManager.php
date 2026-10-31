<?php

namespace App\Services;

use App\Contracts\PaymentGatewayContract;
use App\Services\Gateways\StripeGateway;
use App\Services\Gateways\XsollaGateway;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class PaymentManager
{
    /**
     * @var array<string, PaymentGatewayContract>
     */
    protected array $gateways = [];

    public function __construct(
        StripeGateway $stripeGateway,
        XsollaGateway $xsollaGateway,
    ) {
        $this->registerGateway($stripeGateway);
        $this->registerGateway($xsollaGateway);
    }

    public function registerGateway(PaymentGatewayContract $gateway): self
    {
        $this->gateways[$gateway->id()] = $gateway;

        return $this;
    }

    /**
     * @return Collection<string, PaymentGatewayContract>
     */
    public function allGateways(): Collection
    {
        return collect($this->gateways);
    }

    /**
     * @return Collection<string, PaymentGatewayContract>
     */
    public function getEnabledGateways(): Collection
    {
        return $this->allGateways()->filter(fn (PaymentGatewayContract $g) => $g->isEnabled());
    }

    public function hasAnyEnabledGateway(): bool
    {
        return $this->getEnabledGateways()->isNotEmpty();
    }

    public function isMethodEnabled(string $gatewayId): bool
    {
        $gateway = $this->gateways[$gatewayId] ?? null;

        return $gateway !== null && $gateway->isEnabled();
    }

    public function getGateway(?string $gatewayId = null): PaymentGatewayContract
    {
        if (filled($gatewayId)) {
            $gateway = $this->gateways[$gatewayId] ?? null;

            if (! $gateway || ! $gateway->isEnabled()) {
                throw ValidationException::withMessages([
                    'payment_method' => 'The selected payment method is currently disabled or unavailable.',
                ]);
            }

            return $gateway;
        }

        // Try default gateway from config first
        $defaultId = (string) config('payments.default', 'xsolla');
        if (isset($this->gateways[$defaultId]) && $this->gateways[$defaultId]->isEnabled()) {
            return $this->gateways[$defaultId];
        }

        // Fallback to first enabled gateway
        $firstEnabled = $this->getEnabledGateways()->first();
        if ($firstEnabled) {
            return $firstEnabled;
        }

        throw ValidationException::withMessages([
            'payment_method' => 'Online checkout is temporarily unavailable as no payment methods are active. Please contact support.',
        ]);
    }
}

