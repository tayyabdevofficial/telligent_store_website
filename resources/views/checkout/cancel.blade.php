<x-layouts.storefront :title="'Checkout Cancelled'">
    <div class="mx-auto max-w-4xl px-4 py-12 md:px-6">
        <div class="store-card p-8 text-center md:p-12">
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-amber-600">Checkout not completed</p>
            <h1 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-950">Your payment was cancelled.</h1>
            <p class="mt-4 text-base leading-7 text-slate-600">The order draft for <span class="font-bold text-slate-950">{{ $order->custom_title ?: ($order->package?->name ?? 'this payment request') }}</span> still exists in the database, but payment was not confirmed. You can restart checkout any time.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                @if ($order->package && $order->platform)
                    <a href="{{ route('checkout.create', $order->package) }}" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Try again</a>
                @elseif ($order->paymentLink)
                    <a href="{{ route('payments.link.show', $order->paymentLink) }}" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Try again</a>
                @endif
                <a href="{{ route('home') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:text-slate-950">Back to website</a>
            </div>
        </div>
    </div>
</x-layouts.storefront>
