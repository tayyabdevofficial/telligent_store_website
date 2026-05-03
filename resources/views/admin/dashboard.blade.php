<x-layouts::app :title="__('Admin Dashboard')">
    <div class="space-y-6 p-4 md:p-8">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <div class="metric-card border border-emerald-100 bg-[linear-gradient(180deg,#f8fffb_0%,#edfdf4_100%)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">This Week</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">${{ number_format($stats['week_revenue'], 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-emerald-600/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">7 Days</div>
                </div>
                <p class="mt-3 text-sm font-medium text-slate-600">Paid payments since week start</p>
            </div>
            <div class="metric-card border border-amber-100 bg-[linear-gradient(180deg,#fffdf8_0%,#fff6e9_100%)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-amber-700">This Month</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">${{ number_format($stats['month_revenue'], 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-amber-500/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-amber-700">30 Days</div>
                </div>
                <p class="mt-3 text-sm font-medium text-slate-600">Paid payments since month start</p>
            </div>
            <div class="metric-card border border-sky-100 bg-[linear-gradient(180deg,#f8fcff_0%,#eef8ff_100%)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Package Revenue</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">${{ number_format($stats['package_revenue'], 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-sky-600/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-700">Paid</div>
                </div>
                <p class="mt-3 text-sm font-medium text-slate-600">{{ $stats['package_paid_orders'] }} paid package orders</p>
            </div>
            <div class="metric-card border border-violet-100 bg-[linear-gradient(180deg,#fcfbff_0%,#f4f0ff_100%)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-violet-700">Custom Revenue</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">${{ number_format($stats['custom_revenue'], 2) }}</p>
                    </div>
                    <div class="rounded-2xl bg-violet-600/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-violet-700">Custom</div>
                </div>
                <p class="mt-3 text-sm font-medium text-slate-600">{{ $stats['custom_paid_orders'] }} paid custom orders</p>
            </div>
            <div class="metric-card border border-slate-200 bg-[linear-gradient(180deg,#ffffff_0%,#f8fafc_100%)]">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-600">Customers</p>
                        <p class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">{{ $stats['customers'] }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-900/5 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-600">Unique</div>
                </div>
                <p class="mt-3 text-sm font-medium text-slate-600">Unique customer emails across users and payments</p>
            </div>
        </div>

        @php($maxRevenuePoint = max($revenueTrend->max('amount'), 1))

        <div class="grid gap-6 xl:grid-cols-[1.35fr_0.65fr]">
            <div
                data-dashboard-recent-orders
                data-dashboard-poll-url="{{ route('admin.dashboard.recent-orders') }}"
                data-dashboard-poll-interval="5000"
            >
                @include('admin.partials.recent-orders-card', ['recentOrders' => $recentOrders])
            </div>

            <div class="space-y-6">
                <div class="admin-card border border-sky-100 bg-[linear-gradient(180deg,#ffffff_0%,#f3faff_100%)] p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-sky-700">Paid Revenue</p>
                            <h2 class="mt-2 text-lg font-bold text-slate-950">Last 7 days</h2>
                        </div>
                        <div class="rounded-2xl bg-sky-600/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-sky-700">Trend</div>
                    </div>
                    <div class="mt-6 flex h-44 items-end gap-3">
                        @foreach ($revenueTrend as $point)
                            <div class="flex min-w-0 flex-1 flex-col items-center gap-3">
                                <div class="flex h-28 w-full items-end justify-center rounded-3xl bg-white/80 px-2 py-3 shadow-sm shadow-sky-100/60 ring-1 ring-sky-100/70">
                                    <div
                                        class="w-full rounded-2xl bg-[linear-gradient(180deg,#38bdf8_0%,#0284c7_100%)]"
                                        style="height: {{ max(($point['amount'] / $maxRevenuePoint) * 100, $point['amount'] > 0 ? 12 : 4) }}%;"
                                        title="${{ number_format($point['amount'], 2) }}"
                                    ></div>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-500">{{ $point['label'] }}</p>
                                    <p class="mt-1 text-xs text-slate-400">{{ $point['date'] }}</p>
                                    <p class="mt-2 text-xs font-semibold text-slate-700">${{ number_format($point['amount'], 0) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="admin-card border border-emerald-100 bg-[linear-gradient(180deg,#ffffff_0%,#f5fdf8_100%)] p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-emerald-700">Operations</p>
                            <h2 class="mt-2 text-lg font-bold text-slate-950">Order status mix</h2>
                        </div>
                        <div class="rounded-2xl bg-emerald-600/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">Live</div>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach ($statusBreakdown as $status => $metrics)
                            <div class="flex items-center justify-between rounded-2xl bg-white/80 px-4 py-3 shadow-sm shadow-emerald-100/60 ring-1 ring-emerald-100/70">
                                <span class="text-sm font-semibold text-slate-700">{{ str($status)->replace('_', ' ')->title() }}</span>
                                <span class="rounded-full bg-emerald-600/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-emerald-700">
                                    {{ $metrics['orders'] }} · ${{ number_format($metrics['amount'], 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="admin-card border border-violet-100 bg-[linear-gradient(180deg,#ffffff_0%,#f8f5ff_100%)] p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-violet-700">Platform Split</p>
                            <h2 class="mt-2 text-lg font-bold text-slate-950">Top platforms</h2>
                        </div>
                        <div class="rounded-2xl bg-violet-600/10 px-3 py-2 text-xs font-bold uppercase tracking-[0.18em] text-violet-700">Ranked</div>
                    </div>
                    <div class="mt-4 space-y-3">
                        @foreach ($platformPerformance as $platform)
                            <div class="rounded-2xl bg-white/80 px-4 py-3 shadow-sm shadow-violet-100/60 ring-1 ring-violet-100/70">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="font-semibold text-slate-900">{{ $platform->name }}</span>
                                    <span class="rounded-full bg-violet-600/10 px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] text-violet-700">{{ $platform->orders_count }} orders</span>
                                </div>
                                <p class="mt-1 text-sm text-slate-600">${{ number_format($platform->revenue_total ?? 0, 2) }} revenue</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
