<x-layouts.storefront :title="'About Us'">
    <div class="space-y-8">
        <x-public-page-hero
            eyebrow="About us"
            title="Built for selling social media growth services with clarity and control."
            :description="config('business.storefront_name').' operates under '.config('business.legal_name').' and is designed for agencies, operators, and digital service sellers who need one place to manage promotion, engagement, and monetization packages across major social platforms.'"
        />

        <section class="grid gap-6 lg:grid-cols-3">
            <article class="store-card p-6">
                <h2 class="text-xl font-extrabold text-slate-950">What we offer</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">Structured service packages for Facebook, Instagram, YouTube, TikTok, and future platforms, with editable prices, service types, package descriptions, and delivery timelines maintained from one admin panel.</p>
            </article>
            <article class="store-card p-6">
                <h2 class="text-xl font-extrabold text-slate-950">How it works</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">Customers browse public service pages, order with or without an account, pay through Stripe, and admins track the full lifecycle from one dashboard.</p>
            </article>
            <article class="store-card p-6">
                <h2 class="text-xl font-extrabold text-slate-950">Business identity</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600">{{ config('business.legal_name') }} provides customer support through {{ config('business.support_email') }}, {{ config('business.support_phone') ?: 'BUSINESS_SUPPORT_PHONE' }}, and the mailing address listed on the contact and legal pages.</p>
            </article>
        </section>
    </div>
</x-layouts.storefront>
