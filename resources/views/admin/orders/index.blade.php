<x-layouts::app :title="__('Orders')">
    <div class="space-y-6 p-4 md:p-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Orders</h1>
                <p class="mt-2 text-sm text-slate-600">Monitor guest and customer purchases, then move them through fulfillment stages.</p>
            </div>
        </div>

        <form method="GET" class="admin-card p-4 md:p-5">
            <div class="grid gap-4 md:grid-cols-[1.4fr_1fr_1fr_1fr_auto_auto] md:items-end">
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Search email</span>
                    <input type="text" name="email" value="{{ request('email') }}" placeholder="customer@example.com" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm">
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Status</span>
                    <select name="status" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm">
                        <option value="">All statuses</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Date from</span>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm">
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Date to</span>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm">
                </label>
                <button type="submit" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:text-slate-950">Reset</a>
            </div>
        </form>

        <div class="admin-card overflow-hidden">
            <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Order</th>
                        <th class="px-6 py-3 font-semibold">Package</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                        <th class="px-6 py-3 font-semibold">Amount</th>
                        <th class="px-6 py-3 font-semibold">Date &amp; Time</th>
                        <th class="px-6 py-3 font-semibold"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($orders as $order)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">#{{ $order->id }} • {{ $order->customer_name }}</p>
                                <p class="text-xs text-slate-500">{{ $order->customer_email }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $order->paymentLink?->title ?: ($order->custom_title ?: ($order->package?->name ?? 'Package removed')) }}</td>
                            <td class="px-6 py-4">
                                <span class="whitespace-nowrap rounded-full px-3 py-1 text-xs font-semibold {{ $order->status->badgeClasses() }}">{{ $order->status->label() }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">${{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4 text-xs text-slate-600">
                                @php($orderDate = $order->placed_at ?: $order->created_at)
                                <p class="whitespace-nowrap">US: {{ $orderDate?->copy()->timezone('America/New_York')->format('M d, Y h:i A') ?: 'N/A' }}</p>
                                <p class="mt-1 whitespace-nowrap">PK: {{ $orderDate?->copy()->timezone('Asia/Karachi')->format('M d, Y h:i A') ?: 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4 text-right"><a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-sky-600">Open</a></td>
                        </tr>
                    @endforeach
                    @if ($orders->isEmpty())
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">No orders found for the selected filters.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            </div>
        </div>

        {{ $orders->links() }}
    </div>
</x-layouts::app>


