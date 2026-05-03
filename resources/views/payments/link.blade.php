<x-layouts.storefront :title="$paymentLink?->title ?: 'Custom Payment'">
    <div class="mx-auto max-w-3xl px-4 py-10 md:px-6">
        <div class="store-card p-6 md:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Secure payment link</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">{{ $paymentLink?->title ?: 'Custom Payment' }}</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">This payment page is provided by {{ config('business.storefront_name') }} under {{ config('business.legal_name') }}.</p>

            <div class="mt-8 rounded-3xl bg-slate-50 p-5 text-sm">
                <p class="font-semibold text-slate-950">Service summary</p>
                <p class="mt-3 leading-6 text-slate-600">{{ $paymentLink?->description ?: 'Use this page only after support has confirmed the exact service scope, deliverables, and timeline for the quoted amount.' }}</p>
                <p class="text-slate-500">Amount</p>
                @if ($paymentLink)
                    <p class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950">${{ number_format($paymentLink->amount, 2) }}</p>
                @else
                    <input type="number" name="amount" value="{{ old('amount') }}" min="5" step="1" placeholder="Enter amount in USD" class="mt-3 w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-lg font-bold text-slate-950 outline-none transition focus:border-slate-950" form="custom-pay-form" required>
                    <p class="mt-2 text-xs text-slate-500">Minimum custom payment amount is $5.00.</p>
                @endif
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ $paymentLink ? route('payments.link.store', $paymentLink) : route('payments.custom.store') }}" class="mt-8 space-y-5" id="custom-pay-form">
                @csrf
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Full name</span>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" placeholder="Enter your full name" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950" required>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Email address</span>
                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" placeholder="Enter your email address" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950" required>
                </label>

                <button type="submit" class="inline-flex w-full cursor-pointer items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">
                    Pay Now
                </button>
                <p class="text-center text-sm leading-6 text-slate-500">
                    By continuing, you agree to the
                    <a href="{{ route('refund') }}" class="font-semibold text-sky-600 hover:text-sky-700">Refund Policy</a>
                    and
                    <a href="{{ route('terms') }}" class="font-semibold text-sky-600 hover:text-sky-700">Terms &amp; Conditions</a>.
                </p>
                <p class="text-center text-xs leading-5 text-slate-500">
                    Support: {{ config('business.support_email') }} | {{ config('business.support_phone') ?: 'BUSINESS_SUPPORT_PHONE' }}
                </p>
            </form>
        </div>
    </div>
</x-layouts.storefront>
