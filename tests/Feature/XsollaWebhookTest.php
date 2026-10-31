<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class XsollaWebhookTest extends TestCase
{
    use RefreshDatabase;

    protected string $secretKey = 'test_webhook_secret_key';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'payments.gateways.xsolla.enabled' => true,
            'payments.gateways.xsolla.webhook_secret' => $this->secretKey,
        ]);
    }

    protected function sign(string $payload): string
    {
        return 'Signature ' . sha1($payload . $this->secretKey);
    }

    public function test_rejects_webhook_with_invalid_signature(): void
    {
        $payload = json_encode(['notification_type' => 'user_validation']);

        $response = $this->call(
            'POST',
            route('webhooks.xsolla'),
            [],
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => 'Signature invalid_hash_123',
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload,
        );

        $response->assertStatus(400);
    }

    public function test_handles_user_validation_successfully(): void
    {
        $payload = json_encode([
            'notification_type' => 'user_validation',
            'user' => [
                'id' => '12345',
            ],
        ]);

        $response = $this->call(
            'POST',
            route('webhooks.xsolla'),
            [],
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => $this->sign($payload),
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload,
        );

        $response->assertStatus(204);
    }

    public function test_handles_order_paid_webhook_and_marks_order_as_paid(): void
    {
        $order = Order::create([
            'guest_token' => (string) Str::uuid(),
            'customer_name' => 'Alice Walker',
            'customer_email' => 'alice@example.com',
            'currency' => 'usd',
            'subtotal' => 49.99,
            'total' => 49.99,
            'status' => OrderStatus::AwaitingPayment,
        ]);

        $payment = $order->payments()->create([
            'provider' => 'xsolla',
            'provider_session_id' => 'xsolla_token_alice',
            'amount' => 49.99,
            'currency' => 'usd',
            'status' => PaymentStatus::Pending,
            'customer_email' => 'alice@example.com',
        ]);

        $payload = json_encode([
            'notification_type' => 'order_paid',
            'custom_parameters' => [
                'order_id' => (string) $order->id,
                'payment_id' => (string) $payment->id,
            ],
            'transaction' => [
                'id' => 99887766,
                'external_id' => 'txn_xsolla_ext_1',
            ],
            'order' => [
                'id' => 1234567,
                'currency' => 'USD',
                'amount' => 49.99,
            ],
        ]);

        $response = $this->call(
            'POST',
            route('webhooks.xsolla'),
            [],
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => $this->sign($payload),
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload,
        );

        $response->assertStatus(204);

        $order->refresh();
        $payment->refresh();

        $this->assertSame(OrderStatus::Paid, $order->status);
        $this->assertSame(PaymentStatus::Paid, $payment->status);
        $this->assertSame('99887766', $payment->provider_payment_id);
        $this->assertNotNull($payment->paid_at);
    }

    public function test_handles_order_refund_webhook(): void
    {
        $order = Order::create([
            'guest_token' => (string) Str::uuid(),
            'customer_name' => 'Bob Miller',
            'customer_email' => 'bob@example.com',
            'currency' => 'usd',
            'subtotal' => 20.00,
            'total' => 20.00,
            'status' => OrderStatus::Paid,
        ]);

        $payment = $order->payments()->create([
            'provider' => 'xsolla',
            'provider_session_id' => 'xsolla_token_bob',
            'provider_payment_id' => 'tx_9911',
            'amount' => 20.00,
            'currency' => 'usd',
            'status' => PaymentStatus::Paid,
            'customer_email' => 'bob@example.com',
        ]);

        $payload = json_encode([
            'notification_type' => 'refund',
            'custom_parameters' => [
                'order_id' => (string) $order->id,
                'payment_id' => (string) $payment->id,
            ],
            'transaction' => [
                'id' => 9911,
            ],
        ]);

        $response = $this->call(
            'POST',
            route('webhooks.xsolla'),
            [],
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => $this->sign($payload),
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload,
        );

        $response->assertStatus(204);

        $order->refresh();
        $payment->refresh();

        $this->assertSame(OrderStatus::Refunded, $order->status);
        $this->assertSame(PaymentStatus::Refunded, $payment->status);
    }
}

