<x-layouts::app :title="$user->name">
    <div class="space-y-6 p-4 md:p-8">
        <div class="admin-card p-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">{{ $user->name }}</h1>
            <p class="mt-2 text-sm text-slate-600">{{ $user->email }}</p>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Orders</p>
                    <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $user->orders->count() }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Payments</p>
                    <p class="mt-2 text-2xl font-extrabold text-slate-950">{{ $user->payments->count() }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <h2 class="text-lg font-bold text-slate-950">Recent orders</h2>
            <div class="mt-4 space-y-3">
                @forelse ($user->orders->take(8) as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="block rounded-2xl bg-slate-50 p-4 transition hover:bg-slate-100">
                        <p class="font-semibold text-slate-900">#{{ $order->id }} • {{ $order->paymentLink?->title ?: ($order->package?->name ?? 'Package removed') }}</p>
                        <p class="mt-1 text-sm text-slate-600">${{ number_format($order->total, 2) }} • {{ $order->status->label() }}</p>
                    </a>
                @empty
                    <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-500">No recent orders found for this user.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>
