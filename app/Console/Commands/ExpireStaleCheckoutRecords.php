<?php

namespace App\Console\Commands;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireStaleCheckoutRecords extends Command
{
    protected $signature = 'checkout:expire-stale {--hours=1 : Hours before pending checkout records expire}';

    protected $description = 'Expire pending payments and awaiting-payment orders after the configured checkout window.';

    public function handle(): int
    {
        $hours = max(1, (int) $this->option('hours'));
        $cutoff = now()->subHours($hours);
        $expiredPayments = 0;
        $expiredOrders = 0;

        DB::transaction(function () use ($cutoff, &$expiredPayments, &$expiredOrders): void {
            Payment::query()
                ->with('order')
                ->where('status', PaymentStatus::Pending->value)
                ->where('created_at', '<=', $cutoff)
                ->chunkById(100, function ($payments) use (&$expiredPayments, &$expiredOrders): void {
                    foreach ($payments as $payment) {
                        $payment->forceFill([
                            'status' => PaymentStatus::Expired,
                        ])->save();

                        $expiredPayments++;

                        if ($payment->order && in_array($payment->order->status, [OrderStatus::Pending, OrderStatus::AwaitingPayment], true)) {
                            $payment->order->forceFill([
                                'status' => OrderStatus::Expired,
                            ])->save();

                            $expiredOrders++;
                        }
                    }
                });

            Order::query()
                ->where('status', OrderStatus::AwaitingPayment->value)
                ->where('updated_at', '<=', $cutoff)
                ->chunkById(100, function ($orders) use (&$expiredOrders): void {
                    foreach ($orders as $order) {
                        $order->forceFill([
                            'status' => OrderStatus::Expired,
                        ])->save();

                        $order->payments()
                            ->where('status', PaymentStatus::Pending->value)
                            ->update(['status' => PaymentStatus::Expired->value]);

                        $expiredOrders++;
                    }
                });
        });

        $this->info("Expired {$expiredPayments} pending payments and {$expiredOrders} awaiting-payment orders.");

        return self::SUCCESS;
    }
}

