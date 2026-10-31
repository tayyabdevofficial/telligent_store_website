<x-layouts.storefront :title="$paymentLink?->title ?: 'Custom Payment'">
    <div class="mx-auto max-w-3xl px-4 py-10 md:px-6">
        <div class="store-card p-6 md:p-8">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Secure payment link</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">{{ $paymentLink?->title ?: 'Custom Payment' }}</h1>
            
            @php
                $gateways = $enabledGateways ?? collect();
            @endphp

            @if ($gateways->isEmpty())
                <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                    <span class="font-semibold">Notice:</span> Online payment methods are currently disabled for maintenance. Please reach out to support for assistance.
                </div>
            @else
                <p class="mt-3 text-sm leading-6 text-slate-600">This payment page is provided securely by {{ config('business.storefront_name') }} under {{ config('business.legal_name') }}.</p>
            @endif

            <div class="mt-8 rounded-3xl bg-slate-50 p-5 text-sm">
                <p class="font-semibold text-slate-950">Service summary</p>
                <p class="mt-3 leading-6 text-slate-600">{{ $paymentLink?->description ?: 'Use this page only after support has confirmed the exact service scope, deliverables, and timeline for the quoted amount.' }}</p>
                <p class="mt-4 text-slate-500">Amount</p>
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

                @if ($gateways->count() > 1)
                    <div class="pt-2">
                        <span class="mb-3 block text-sm font-semibold text-slate-700">Select payment method</span>
                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach ($gateways as $gateway)
                                <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-sky-500 has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/50">
                                    <input type="radio" name="payment_method" value="{{ $gateway->id() }}" @checked(old('payment_method', $loop->first ? $gateway->id() : null) === $gateway->id()) class="text-sky-600 focus:ring-sky-500">
                                    <div>
                                        <p class="font-semibold text-slate-900 text-sm">{{ $gateway->name() }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @elseif ($gateways->count() === 1)
                    <input type="hidden" name="payment_method" value="{{ $gateways->first()->id() }}">
                    <div class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-600">
                        <span class="font-semibold text-slate-900">Payment provider:</span>
                        <span>{{ $gateways->first()->name() }}</span>
                    </div>
                @endif

                <button type="submit" @disabled($gateways->isEmpty()) class="inline-flex w-full cursor-pointer items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600 disabled:opacity-50 disabled:cursor-not-allowed">
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
