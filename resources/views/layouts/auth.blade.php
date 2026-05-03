<x-layouts.storefront :title="$title ?? null">
    <div class="mx-auto max-w-5xl">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <section class="store-card hidden p-8 lg:flex lg:flex-col">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">{{ config('business.storefront_name') }} account</p>
                <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-950">Access your campaigns, orders, and client history.</h2>
                <p class="mt-5 text-base leading-7 text-slate-600">Authentication now matches the storefront experience so customers move between browsing and account actions without a visual disconnect. {{ config('business.storefront_name') }} operates under {{ config('business.legal_name') }}.</p>
                <div class="mt-auto rounded-3xl bg-slate-50 p-6">
                    <p class="text-sm font-bold text-slate-900">What you can manage after login</p>
                    <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                        <li>Track paid and active service orders.</li>
                        <li>View package history and spending.</li>
                        <li>Manage profile, password, and security settings.</li>
                    </ul>
                </div>
            </section>

            <section class="store-card p-6 md:p-8">
                {{ $slot }}
            </section>
        </div>
    </div>
</x-layouts.storefront>
