<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Requests\CustomAmountPaymentRequest;
use App\Http\Requests\PaymentLinkCheckoutRequest;
use App\Models\Order;
use App\Models\PaymentLink;
use App\Services\StripeCheckoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentLinkController extends Controller
{
    public function custom(): View
    {
        $paymentLink = null;

        return view('payments.link', compact('paymentLink'));
    }

    public function storeCustom(
        CustomAmountPaymentRequest $request,
        StripeCheckoutService $stripeCheckoutService,
    ): RedirectResponse {
        $validated = $request->validated();

        [$order, $payment] = DB::transaction(function () use ($validated) {
            $amount = (float) $validated['amount'];
            $title = 'Custom amount payment';
            $description = 'Custom billed digital service request. Submit payment only after support has confirmed the exact deliverables, target links, and timeline for this order.';

            $order = Order::create([
                'user_id' => null,
                'social_platform_id' => null,
                'service_package_id' => null,
                'payment_link_slug' => null,
                'guest_token' => (string) Str::uuid(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => null,
                'target_link' => null,
                'custom_title' => $title,
                'custom_description' => $description,
                'requirements' => null,
                'currency' => 'usd',
                'subtotal' => $amount,
                'total' => $amount,
                'status' => OrderStatus::Pending,
                'placed_at' => now(),
            ]);

            $order->items()->create([
                'service_package_id' => null,
                'package_name' => $title,
                'service_type' => 'custom_amount_payment',
                'unit_price' => $amount,
                'quantity' => 1,
                'line_total' => $amount,
            ]);

            $payment = $order->payments()->create([
                'user_id' => null,
                'provider' => 'stripe',
                'amount' => $amount,
                'currency' => 'usd',
                'status' => PaymentStatus::Pending,
                'customer_email' => $validated['customer_email'],
            ]);

            return [$order, $payment];
        });

        $session = $stripeCheckoutService->createCheckoutSession(
            $order,
            $payment,
            $order->custom_title,
            $order->custom_description,
        );

        $payment->forceFill([
            'provider_session_id' => $session->id,
            'provider_payment_id' => $session->payment_intent,
            'payload' => $session->toArray(),
        ])->save();

        $order->forceFill([
            'status' => OrderStatus::AwaitingPayment,
        ])->save();

        return redirect()->away($session->url);
    }

    public function show(PaymentLink $paymentLink): View
    {
        abort_unless($paymentLink->is_active, 404);

        return view('payments.link', compact('paymentLink'));
    }

    public function store(
        PaymentLinkCheckoutRequest $request,
        PaymentLink $paymentLink,
        StripeCheckoutService $stripeCheckoutService,
    ): RedirectResponse {
        abort_unless($paymentLink->is_active, 404);

        $validated = $request->validated();

        [$order, $payment] = DB::transaction(function () use ($validated, $paymentLink) {
            $order = Order::create([
                'user_id' => null,
                'social_platform_id' => null,
                'service_package_id' => null,
                'payment_link_slug' => $paymentLink->slug,
                'guest_token' => (string) Str::uuid(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => null,
                'target_link' => null,
                'custom_title' => $paymentLink->title,
                'custom_description' => $paymentLink->description,
                'requirements' => null,
                'currency' => $paymentLink->currency,
                'subtotal' => $paymentLink->amount,
                'total' => $paymentLink->amount,
                'status' => OrderStatus::Pending,
                'placed_at' => now(),
            ]);

            $order->items()->create([
                'service_package_id' => null,
                'package_name' => $paymentLink->title,
                'service_type' => 'custom_payment',
                'unit_price' => $paymentLink->amount,
                'quantity' => 1,
                'line_total' => $paymentLink->amount,
            ]);

            $payment = $order->payments()->create([
                'user_id' => null,
                'provider' => 'stripe',
                'amount' => $paymentLink->amount,
                'currency' => $paymentLink->currency,
                'status' => PaymentStatus::Pending,
                'customer_email' => $validated['customer_email'],
            ]);

            return [$order, $payment];
        });

        $session = $stripeCheckoutService->createCheckoutSession(
            $order,
            $payment,
            $paymentLink->title,
            $paymentLink->description,
        );

        $payment->forceFill([
            'provider_session_id' => $session->id,
            'provider_payment_id' => $session->payment_intent,
            'payload' => $session->toArray(),
        ])->save();

        $order->forceFill([
            'status' => OrderStatus::AwaitingPayment,
        ])->save();

        return redirect()->away($session->url);
    }
}
