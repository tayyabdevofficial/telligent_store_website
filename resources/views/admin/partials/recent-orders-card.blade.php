<div class="admin-card overflow-hidden border border-slate-200 bg-[linear-gradient(180deg,#ffffff_0%,#f8fbff_100%)]">
    <div class="border-b border-slate-200/80 px-6 py-5">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Order Feed</p>
                <h2 class="mt-2 text-xl font-bold tracking-tight text-slate-950">Recent orders</h2>
            </div>
            <div class="rounded-2xl bg-sky-600/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-700">Live</div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[860px] divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-950/[0.03] text-left text-[11px] font-bold uppercase tracking-[0.18em] text-slate-500">
                <tr>
                    <th class="px-6 py-3 font-semibold">Customer</th>
                    <th class="px-6 py-3 font-semibold">Package</th>
                    <th class="px-6 py-3 font-semibold">Status</th>
                    <th class="px-6 py-3 font-semibold">Amount</th>
                    <th class="px-6 py-3 font-semibold">Date &amp; Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200/80 bg-transparent">
                @forelse ($recentOrders as $order)
                    <tr class="bg-white/70 transition hover:bg-sky-50/60">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-slate-900 hover:text-sky-600">{{ $order->customer_name }}</a>
                            <p class="mt-1 text-xs text-slate-500">{{ $order->customer_email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ $order->paymentLink?->title ?: ($order->package?->name ?? 'Custom amount') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="whitespace-nowrap rounded-full px-3 py-1 text-xs font-semibold {{ $order->status->badgeClasses() }}">{{ $order->status->label() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">${{ number_format($order->total, 2) }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600">
                            @php($orderDate = $order->placed_at ?: $order->created_at)
                            <p class="whitespace-nowrap"><span class="font-semibold text-slate-700">US:</span> {{ $orderDate?->copy()->timezone('America/New_York')->format('M d, Y h:i A') ?: 'N/A' }}</p>
                            <p class="mt-1 whitespace-nowrap"><span class="font-semibold text-slate-700">PK:</span> {{ $orderDate?->copy()->timezone('Asia/Karachi')->format('M d, Y h:i A') ?: 'N/A' }}</p>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No recent orders available yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


