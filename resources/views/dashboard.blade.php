<x-layouts::app :title="__('Dashboard')">
    <div class="space-y-6 p-4 md:p-8">
        <div class="admin-card p-6 md:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Customer dashboard</p>
            <div class="mt-3 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Your service orders in one place</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-600">Track active campaigns, review completed orders, and monitor your spending history without leaving the dashboard.</p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">
                    Browse services
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="metric-card">
                <p class="text-sm text-slate-500">Total orders</p>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $stats['orders'] }}</p>
            </div>
            <div class="metric-card">
                <p class="text-sm text-slate-500">Active orders</p>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $stats['active_orders'] }}</p>
            </div>
            <div class="metric-card">
                <p class="text-sm text-slate-500">Total spent</p>
                <p class="mt-3 text-3xl font-extrabold text-slate-950">${{ number_format($stats['spent'], 2) }}</p>
            </div>
        </div>

        <div class="admin-card overflow-hidden">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-lg font-bold text-slate-950">Recent orders</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Package</th>
                            <th class="px-6 py-3 font-semibold">Platform</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold">Amount</th>
                            <th class="px-6 py-3 font-semibold">Placed</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 font-semibold text-slate-900">{{ $order->package?->name ?? 'Package removed' }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $order->package?->platform?->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status->badgeClasses() }}">{{ $order->status->label() }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-700">${{ number_format($order->total, 2) }}</td>
                                <td class="px-6 py-4 text-slate-500">{{ optional($order->placed_at)->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">No orders yet. Start with a promotion or monetization package from the storefront.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app>

