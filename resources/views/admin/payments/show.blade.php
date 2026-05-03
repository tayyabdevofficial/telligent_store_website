<x-layouts::app :title="'Payment #'.$payment->id">
    <div class="max-w-4xl p-4 md:p-8">
        <div class="admin-card p-6">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Payment #{{ $payment->id }}</h1>
            @if (session('status'))
                <div class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif
            <div class="mt-6 grid gap-4 text-sm md:grid-cols-2">
                <div><p class="text-slate-500">Provider</p><p class="mt-1 font-semibold text-slate-900">{{ strtoupper(str_replace('_', ' ', $payment->provider)) }}</p></div>
                <div>
                    <p class="text-slate-500">Status</p>
                    <p class="mt-2">
                        <span class="whitespace-nowrap rounded-full px-3 py-1 text-xs font-semibold {{ $payment->status->badgeClasses() }}">{{ $payment->status->label() }}</span>
                    </p>
                </div>
                <div><p class="text-slate-500">Amount</p><p class="mt-1 font-semibold text-slate-900">${{ number_format($payment->amount, 2) }}</p></div>
                <div><p class="text-slate-500">Order</p><p class="mt-1 font-semibold text-slate-900">#{{ $payment->order_id }}</p></div>
                <div><p class="text-slate-500">Title</p><p class="mt-1 font-semibold text-slate-900">{{ $payment->order?->custom_title ?: ($payment->order?->package?->name ?: 'Standard payment') }}</p></div>
                <div class="md:col-span-2"><p class="text-slate-500">Stripe session id</p><p class="mt-1 break-all font-semibold text-slate-900">{{ $payment->provider_session_id ?: 'N/A' }}</p></div>
                <div class="md:col-span-2"><p class="text-slate-500">Stripe payment intent</p><p class="mt-1 break-all font-semibold text-slate-900">{{ $payment->provider_payment_id ?: 'N/A' }}</p></div>
            </div>
        </div>
    </div>
</x-layouts::app>


