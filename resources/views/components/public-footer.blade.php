<footer class="mt-16 border-t border-slate-200/80 py-10">
    <div class="grid gap-8 md:grid-cols-[1.2fr_0.8fr]">
        <div>
            <div class="flex items-center gap-3">
                <img src="{{ asset('brand/telligent-mark.svg') }}" alt="Telligent Store" class="size-11 rounded-2xl">
                <div>
                    <p class="text-lg font-extrabold tracking-tight text-slate-950">{{ config('business.storefront_name') }}</p>
                    <p class="text-sm text-slate-500">A social-growth service brand operating under {{ config('business.legal_name') }}.</p>
                </div>
            </div>
            <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-600">{{ config('business.storefront_name') }} operates under {{ config('business.legal_name') }} and provides promotion, monetization, engagement, and custom-payment services for modern social brands and creators.</p>
            <div class="mt-5 space-y-2 text-sm leading-6 text-slate-600">
                <p><span class="font-semibold text-slate-950">Support email:</span> {{ config('business.support_email') }}</p>
                <p><span class="font-semibold text-slate-950">Support phone:</span> {{ config('business.support_phone') ?: 'Set BUSINESS_SUPPORT_PHONE in your .env file.' }}</p>
                <p><span class="font-semibold text-slate-950">Mailing address:</span> {{ config('business.mailing_address') ?: 'Set BUSINESS_MAILING_ADDRESS in your .env file.' }}</p>
                <p><span class="font-semibold text-slate-950">Business hours:</span> {{ config('business.business_hours') }}</p>
            </div>
        </div>

        <div class="grid gap-8 sm:grid-cols-2">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Company</p>
                <div class="mt-4 flex flex-col gap-3 text-sm font-semibold text-slate-600">
                    <a href="{{ route('about') }}" class="transition hover:text-slate-950">About us</a>
                    <a href="{{ route('contact') }}" class="transition hover:text-slate-950">Contact us</a>
                    <a href="{{ route('home') }}#platforms" class="transition hover:text-slate-950">Services</a>
                </div>
            </div>
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Legal</p>
                <div class="mt-4 flex flex-col gap-3 text-sm font-semibold text-slate-600">
                    <a href="{{ route('privacy') }}" class="transition hover:text-slate-950">Privacy policy</a>
                    <a href="{{ route('refund') }}" class="transition hover:text-slate-950">Refund policy</a>
                    <a href="{{ route('terms') }}" class="transition hover:text-slate-950">Terms & conditions</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 flex flex-col gap-2 border-t border-slate-200 pt-6 text-sm text-slate-500 md:flex-row md:items-center md:justify-between">
        <p>&copy; {{ now()->year }} {{ config('business.storefront_name') }}, under {{ config('business.legal_name') }}. All rights reserved.</p>
        <p>Support for Facebook, Instagram, YouTube, TikTok, and custom campaign packages.</p>
    </div>
</footer>
