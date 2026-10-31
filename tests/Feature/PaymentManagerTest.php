<?php

namespace Tests\Feature;

use App\Services\PaymentManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PaymentManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_loads_enabled_gateways_according_to_configuration(): void
    {
        config([
            'payments.gateways.stripe.enabled' => false,
            'payments.gateways.xsolla.enabled' => true,
        ]);

        $manager = app(PaymentManager::class);

        $this->assertFalse($manager->isMethodEnabled('stripe'));
        $this->assertTrue($manager->isMethodEnabled('xsolla'));

        $enabled = $manager->getEnabledGateways();
        $this->assertCount(1, $enabled);
        $this->assertTrue($enabled->has('xsolla'));
        $this->assertFalse($enabled->has('stripe'));
    }

    public function test_resolves_default_gateway_when_none_specified(): void
    {
        config([
            'payments.default' => 'xsolla',
            'payments.gateways.stripe.enabled' => false,
            'payments.gateways.xsolla.enabled' => true,
        ]);

        $manager = app(PaymentManager::class);
        $gateway = $manager->getGateway();

        $this->assertSame('xsolla', $gateway->id());
    }

    public function test_throws_validation_exception_when_all_gateways_are_disabled(): void
    {
        config([
            'payments.gateways.stripe.enabled' => false,
            'payments.gateways.xsolla.enabled' => false,
        ]);

        $manager = app(PaymentManager::class);

        $this->expectException(ValidationException::class);
        $manager->getGateway();
    }

    public function test_throws_validation_exception_when_requesting_disabled_gateway(): void
    {
        config([
            'payments.gateways.stripe.enabled' => false,
            'payments.gateways.xsolla.enabled' => true,
        ]);

        $manager = app(PaymentManager::class);

        $this->expectException(ValidationException::class);
        $manager->getGateway('stripe');
    }
}

