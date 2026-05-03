<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Models\Order;
use App\Models\Payment;
use App\Models\SocialPlatform;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        if (auth()->user()->role === UserRole::Admin) {
            $paidPayments = Payment::query()
                ->where('status', PaymentStatus::Paid);

            $paidPackagePayments = Payment::query()
                ->where('status', PaymentStatus::Paid)
                ->whereHas('order', fn ($query) => $query->whereNotNull('service_package_id'));

            $paidCustomPayments = Payment::query()
                ->where('status', PaymentStatus::Paid)
                ->whereHas('order', fn ($query) => $query->whereNull('service_package_id'));

            $stats = [
                'package_revenue' => (clone $paidPackagePayments)->sum('amount'),
                'package_paid_orders' => (clone $paidPackagePayments)->count(),
                'custom_revenue' => (clone $paidCustomPayments)->sum('amount'),
                'custom_paid_orders' => (clone $paidCustomPayments)->count(),
                'week_revenue' => (clone $paidPayments)
                    ->where('paid_at', '>=', now()->startOfWeek())
                    ->sum('amount'),
                'month_revenue' => (clone $paidPayments)
                    ->where('paid_at', '>=', now()->startOfMonth())
                    ->sum('amount'),
                'customers' => User::query()
                    ->where('role', UserRole::User)
                    ->pluck('email')
                    ->merge(
                        Payment::query()
                            ->whereNotNull('customer_email')
                            ->pluck('customer_email')
                    )
                    ->filter()
                    ->map(fn ($email) => strtolower(trim((string) $email)))
                    ->unique()
                    ->count(),
            ];

            $recentOrders = $this->getRecentOrders();

            $statusBreakdown = Order::query()
                ->selectRaw('status, count(*) as total_orders, coalesce(sum(total), 0) as total_amount')
                ->groupBy('status')
                ->get()
                ->mapWithKeys(fn ($row) => [
                    $row->status->value => [
                        'orders' => (int) $row->total_orders,
                        'amount' => (float) $row->total_amount,
                    ],
                ]);

            $platformPerformance = SocialPlatform::query()
                ->withCount('orders')
                ->withSum('orders as revenue_total', 'total')
                ->orderByDesc('orders_count')
                ->limit(6)
                ->get();

            $dailyRevenue = Payment::query()
                ->where('status', PaymentStatus::Paid)
                ->where('paid_at', '>=', now()->subDays(6)->startOfDay())
                ->selectRaw('DATE(paid_at) as paid_date, SUM(amount) as total_amount')
                ->groupBy('paid_date')
                ->pluck('total_amount', 'paid_date');

            $revenueTrend = Collection::times(7, function (int $dayOffset) use ($dailyRevenue): array {
                $date = now()->subDays(6 - ($dayOffset - 1))->startOfDay();
                $key = $date->toDateString();

                return [
                    'label' => $date->format('D'),
                    'date' => $date->format('M d'),
                    'amount' => (float) ($dailyRevenue[$key] ?? 0),
                ];
            });

            return view('admin.dashboard', compact('stats', 'recentOrders', 'statusBreakdown', 'platformPerformance', 'revenueTrend'));
        }

        $orders = auth()->user()
            ->orders()
            ->with(['package.platform', 'payments'])
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'orders' => auth()->user()->orders()->count(),
            'active_orders' => auth()->user()->orders()->whereIn('status', [
                OrderStatus::Paid,
                OrderStatus::Processing,
            ])->count(),
            'spent' => auth()->user()->payments()->where('status', PaymentStatus::Paid)->sum('amount'),
        ];

        return view('dashboard', compact('orders', 'stats'));
    }

    public function recentOrders(Request $request): Response
    {
        abort_unless(
            $request->user()?->role === UserRole::Admin,
            Response::HTTP_FORBIDDEN
        );

        return response(
            view('admin.partials.recent-orders-card', [
                'recentOrders' => $this->getRecentOrders(),
            ])->render()
        );
    }

    protected function getRecentOrders(): Collection
    {
        return Order::query()
            ->with(['package.platform', 'payments'])
            ->latest()
            ->limit(15)
            ->get();
    }
}
