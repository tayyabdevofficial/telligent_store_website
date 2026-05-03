<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\ServicePackage;
use App\Services\StripeCheckoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(ServicePackage $package): View
    {
        abort_unless($package->is_active, 404);

        return view('checkout.create', compact('package'));
    }

    public function store(
        CheckoutRequest $request,
        ServicePackage $package,
        StripeCheckoutService $stripeCheckoutService,
    ): RedirectResponse {
        abort_unless($package->is_active, 404);

        $validated = $request->validated();

        [$order, $payment] = DB::transaction(function () use ($validated, $package, $request) {
            $order = Order::create([
                'user_id' => $request->user()?->id,
                'social_platform_id' => $package->social_platform_id,
                'service_package_id' => $package->id,
                'guest_token' => (string) Str::uuid(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => null,
                'target_link' => null,
                'requirements' => null,
                'currency' => 'usd',
                'subtotal' => $package->price,
                'total' => $package->price,
                'status' => OrderStatus::Pending,
                'placed_at' => now(),
            ]);

            $order->items()->create([
                'service_package_id' => $package->id,
                'package_name' => $package->name,
                'service_type' => $package->service_type,
                'unit_price' => $package->price,
                'quantity' => 1,
                'line_total' => $package->price,
            ]);

            $payment = $order->payments()->create([
                'user_id' => $request->user()?->id,
                'provider' => 'stripe',
                'amount' => $order->total,
                'currency' => $order->currency,
                'status' => PaymentStatus::Pending,
                'customer_email' => $order->customer_email,
            ]);

            return [$order, $payment];
        });

        $session = $stripeCheckoutService->createCheckoutSession(
            $order,
            $payment,
            $package->name,
            $package->description,
        );

        $payment->forceFill([
            'provider_session_id' => $session->id,
            'provider_payment_id' => $session->payment_intent,
            'payload' => $session->toArray(),
        ])->save();

        $order->update([
            'status' => OrderStatus::AwaitingPayment,
        ]);

        return redirect()->away($session->url);
    }

    public function success(
        Request $request,
        Order $order,
        string $token,
        StripeCheckoutService $stripeCheckoutService,
    ): View {
        abort_unless($order->guest_token === $token, 404);

        if ($request->filled('session_id')) {
            $stripeCheckoutService->syncOrderFromSession($order, $request->string('session_id')->toString());
            $order->refresh();
        }

        return view('checkout.success', compact('order'));
    }

    public function cancel(Order $order, string $token): View
    {
        abort_unless($order->guest_token === $token, 404);

        return view('checkout.cancel', compact('order'));
    }
}
