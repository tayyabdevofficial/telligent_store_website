<x-layouts::app :title="'Order #'.$order->id">
    <div class="space-y-6 p-4 md:p-8">
        <div class="admin-card p-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Order #{{ $order->id }}</h1>
            <div class="mt-6 grid gap-4 text-sm md:grid-cols-2">
                <div><p class="text-slate-500">Customer</p><p class="mt-1 font-semibold text-slate-900">{{ $order->customer_name }}</p><p class="text-slate-600">{{ $order->customer_email }}</p></div>
                <div><p class="text-slate-500">Target link</p><p class="mt-1 break-all font-semibold text-slate-900">{{ $order->target_link ?: 'Not provided' }}</p></div>
                <div><p class="text-slate-500">Package</p><p class="mt-1 font-semibold text-slate-900">{{ $order->custom_title ?: ($order->package?->name ?? 'Package removed') }}</p></div>
                <div><p class="text-slate-500">Amount</p><p class="mt-1 font-semibold text-slate-900">${{ number_format($order->total, 2) }}</p></div>
            </div>
            @if ($order->custom_description)
                <div class="mt-6 rounded-2xl bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                    <p class="font-bold text-slate-900">Billing description</p>
                    <p class="mt-2">{{ $order->custom_description }}</p>
                </div>
            @endif
            @if ($order->paymentLink)
                <div class="mt-6 rounded-2xl bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                    <p class="font-bold text-slate-900">Payment link</p>
                    <p class="mt-2 break-all">{{ route('payments.link.show', $order->paymentLink) }}</p>
                </div>
            @endif
            @if ($order->requirements)
                <div class="mt-6 rounded-2xl bg-slate-50 p-4 text-sm leading-6 text-slate-600">
                    <p class="font-bold text-slate-900">Customer notes</p>
                    <p class="mt-2">{{ $order->requirements }}</p>
                </div>
            @endif
        </div>

        <div class="admin-card p-6">
            <h2 class="text-lg font-bold text-slate-950">Payment history</h2>
            <div class="mt-4 space-y-3">
                @forelse ($order->payments as $payment)
                    <div class="rounded-2xl bg-slate-50 p-4 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <span class="font-semibold text-slate-900">{{ strtoupper(str_replace('_', ' ', $payment->provider)) }}</span>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $payment->status->badgeClasses() }}">{{ $payment->status->label() }}</span>
                        </div>
                        <p class="mt-2 text-slate-600">${{ number_format($payment->amount, 2) }} • {{ $payment->customer_email }}</p>
                    </div>
                @empty
                    <div class="rounded-2xl bg-slate-50 p-4 text-sm text-slate-500">No payment records found for this order.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>


