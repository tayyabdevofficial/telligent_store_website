<x-layouts.storefront :title="'Contact Us'">
    <div class="space-y-8">
        <x-public-page-hero
            eyebrow="Contact us"
            title="Reach out for custom packages, support, or partnership discussions."
            :description="'Use the details below to discuss campaign requirements, enterprise pricing, order support, or billing questions for '.config('business.storefront_name').', operated by '.config('business.legal_name').'.'"
        />

        <section class="grid gap-6 lg:grid-cols-4">
            <article class="store-card p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Business email</p>
                <h2 class="mt-3 text-xl font-extrabold text-slate-950">{{ config('business.support_email') }}</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">Use email support for order updates, billing questions, account issues, and service clarifications.</p>
            </article>
            <article class="store-card p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Support phone</p>
                <h2 class="mt-3 text-xl font-extrabold text-slate-950">{{ config('business.support_phone') ?: 'Set BUSINESS_SUPPORT_PHONE' }}</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">Stripe and card-network reviews expect a direct support phone number to be visible to customers before payment.</p>
            </article>
            <article class="store-card p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Mailing address</p>
                <h2 class="mt-3 text-xl font-extrabold text-slate-950">{{ config('business.legal_name') }}</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">{{ config('business.mailing_address') ?: 'Set BUSINESS_MAILING_ADDRESS in your .env file so the mailing address is visible here.' }}</p>
            </article>
            <article class="store-card p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Business hours</p>
                <h2 class="mt-3 text-xl font-extrabold text-slate-950">{{ config('business.business_hours') }}</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">Contact us for custom quantities, agency bundles, or platform-specific campaign planning during posted support hours.</p>
            </article>
        </section>
    </div>
</x-layouts.storefront>
