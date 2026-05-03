<x-layouts.storefront :title="'Order Confirmed'">
    <div class="mx-auto max-w-4xl px-4 py-12 md:px-6">
        <div class="store-card p-8 text-center md:p-12">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-emerald-600">Payment received</p>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-950">Your order has been recorded.</h1>
            <p class="mt-4 text-base leading-7 text-slate-600">Order <span class="font-bold text-slate-950">#{{ $order->id }}</span> is now in the system with status <span class="font-bold text-slate-950">{{ $order->status->label() }}</span>. Admin can review the package, payment, and customer details from the dashboard.</p>

            <div class="mt-8 grid gap-4 text-left md:grid-cols-2">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Customer</p>
                    <p class="mt-2 text-lg font-bold text-slate-950">{{ $order->customer_name }}</p>
                    <p class="mt-1 text-sm text-slate-600">{{ $order->customer_email }}</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Total paid</p>
                    <p class="mt-2 text-lg font-bold text-slate-950">${{ number_format($order->total, 2) }}</p>
                    <p class="mt-1 text-sm text-slate-600">{{ $order->custom_title ?: ($order->package?->name ?? 'Custom payment') }}</p>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Back to website</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:text-slate-950">Open dashboard</a>
                @endauth
            </div>
        </div>
    </div>
</x-layouts.storefront>
