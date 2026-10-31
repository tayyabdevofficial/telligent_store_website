<x-layouts.storefront :title="'Checkout - '.$package->name">
    <div class="mx-auto max-w-3xl px-4 py-8 md:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl">
            <form method="POST" action="{{ route('checkout.store', $package) }}" class="store-card p-6 md:p-8">
                @csrf
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Secure checkout</p>
                <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">Complete your order</h1>
                
                @php
                    $gateways = $enabledGateways ?? collect();
                @endphp

                @if ($gateways->isEmpty())
                    <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                        <span class="font-semibold">Notice:</span> Online payment methods are currently disabled for maintenance. Please reach out to support for assistance.
                    </div>
                @else
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        This form works for guest buyers and logged-in customers. Payment is processed securely for {{ config('business.storefront_name') }}, operating under {{ config('business.legal_name') }}.
                    </p>
                @endif

                <div class="mt-6 rounded-3xl border border-slate-200 bg-slate-50 px-5 py-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Package</p>
                    <p class="mt-2 text-2xl font-extrabold tracking-tight text-slate-950">{{ $package->name }}</p>
                    <p class="mt-3 text-sm leading-6 text-slate-600">{{ $package->description }}</p>
                    <div class="mt-4 flex flex-wrap gap-3 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        <span>{{ $package->platform->name }}</span>
                        <span>{{ $package->service_type }}</span>
                        <span>{{ $package->delivery_timeline }}</span>
                    </div>
                    <p class="mt-5 text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Amount</p>
                    <p class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950">${{ number_format($package->price, 2) }}</p>
                </div>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mt-8 grid gap-5 md:grid-cols-2">
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Full name</span>
                        <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" placeholder="Enter your full name" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Email address</span>
                        <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" placeholder="Enter your email address" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-slate-950" required>
                    </label>
                </div>

                @if ($gateways->count() > 1)
                    <div class="mt-6">
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
                    <div class="mt-6 flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-600">
                        <span class="font-semibold text-slate-900">Payment provider:</span>
                        <span>{{ $gateways->first()->name() }}</span>
                    </div>
                @endif

                <button type="submit" @disabled($gateways->isEmpty()) class="mt-8 inline-flex w-full cursor-pointer items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    Pay Now - ${{ number_format($package->price, 2) }}
                </button>
                <p class="mt-4 text-center text-sm leading-6 text-slate-500">
                    By continuing, you agree to the
                    <a href="{{ route('refund') }}" class="font-semibold text-sky-600 hover:text-sky-700">Refund Policy</a>
                    and
                    <a href="{{ route('terms') }}" class="font-semibold text-sky-600 hover:text-sky-700">Terms &amp; Conditions</a>.
                </p>
                <p class="mt-3 text-center text-xs leading-5 text-slate-500">
                    Support: {{ config('business.support_email') }} | {{ config('business.support_phone') ?: 'BUSINESS_SUPPORT_PHONE' }}
                </p>
            </form>
        </div>
    </div>
</x-layouts.storefront>
