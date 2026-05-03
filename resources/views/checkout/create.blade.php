<x-layouts.storefront :title="'Checkout - '.$package->name">
    <div class="mx-auto max-w-3xl px-4 py-8 md:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl">
            <form method="POST" action="{{ route('checkout.store', $package) }}" class="store-card p-6 md:p-8">
                @csrf
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Secure checkout</p>
                <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">Complete your order</h1>
                <p class="mt-3 text-sm leading-6 text-slate-600">This form works for guest buyers and logged-in customers. Payment is processed through Stripe for {{ config('business.storefront_name') }}, operating under {{ config('business.legal_name') }}.</p>
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

                <button type="submit" class="mt-8 inline-flex w-full cursor-pointer items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">
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
