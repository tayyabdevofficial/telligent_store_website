<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentLink;
use App\Models\ServicePackage;
use App\Models\SocialPlatform;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class XsollaCheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'payments.default' => 'xsolla',
            'payments.gateways.stripe.enabled' => false,
            'payments.gateways.xsolla.enabled' => true,
            'payments.gateways.xsolla.merchant_id' => '123456',
            'payments.gateways.xsolla.project_id' => '7890',
            'payments.gateways.xsolla.api_key' => 'secret_api_key',
            'payments.gateways.xsolla.sandbox' => true,
        ]);
    }

    public function test_checkout_creates_order_and_redirects_to_xsolla(): void
    {
        $platform = SocialPlatform::create([
            'name' => 'Instagram',
            'slug' => 'instagram',
            'is_active' => true,
        ]);

        $package = ServicePackage::create([
            'social_platform_id' => $platform->id,
            'name' => '1,000 Instagram Followers',
            'slug' => '1000-instagram-followers',
            'service_type' => 'followers',
            'price' => 25.00,
            'is_active' => true,
        ]);

        Http::fake([
            'https://api.xsolla.com/merchant/v2/merchants/123456/token' => Http::response([
                'token' => 'xsolla_mock_token_123',
            ], 200),
        ]);

        $response = $this->post(route('checkout.store', $package), [
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@gmail.com',
        ]);

        $response->assertRedirect('https://sandbox-secure.xsolla.com/paystation4/?token=xsolla_mock_token_123');

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Jane Doe',
            'customer_email' => 'jane@gmail.com',
            'status' => OrderStatus::AwaitingPayment->value,
            'total' => 25.00,
        ]);

        $this->assertDatabaseHas('payments', [
            'provider' => 'xsolla',
            'provider_session_id' => 'xsolla_mock_token_123',
            'status' => PaymentStatus::Pending->value,
            'amount' => 25.00,
        ]);
    }

    public function test_custom_payment_link_redirects_to_xsolla(): void
    {
        $paymentLink = PaymentLink::create([
            'title' => 'Custom Growth Campaign',
            'slug' => 'custom-growth-campaign',
            'amount' => 150.00,
            'currency' => 'usd',
            'is_active' => true,
        ]);

        Http::fake([
            'https://api.xsolla.com/merchant/v2/merchants/123456/token' => Http::response([
                'token' => 'custom_link_token_abc',
            ], 200),
        ]);

        $response = $this->post(route('payments.link.store', $paymentLink), [
            'customer_name' => 'John Smith',
            'customer_email' => 'john@gmail.com',
        ]);

        $response->assertRedirect('https://sandbox-secure.xsolla.com/paystation4/?token=custom_link_token_abc');

        $this->assertDatabaseHas('payments', [
            'provider' => 'xsolla',
            'provider_session_id' => 'custom_link_token_abc',
            'amount' => 150.00,
        ]);
    }
}
