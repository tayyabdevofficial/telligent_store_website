<x-layouts.storefront :title="'Refund Policy'">
    <div class="space-y-8">
        <x-public-page-hero
            eyebrow="Refund policy"
            title="Refund terms for digital promotion, monetization, and custom payment services."
            :description="'This policy explains when refunds, credits, and dispute reviews may apply to purchases made through '.config('business.storefront_name').', operated by '.config('business.legal_name').'.'"
        />

        <section class="store-card p-6 md:p-8">
            <div class="space-y-6 text-sm leading-7 text-slate-600">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Business identity</h2>
                    <p class="mt-2">This refund policy applies to {{ config('business.storefront_name') }} as a service brand operating under {{ config('business.legal_name') }}. All checkout pages, direct payment pages, and reusable payment-link pages published through this website fall under this policy. Support is available at {{ config('business.support_email') }}, {{ config('business.support_phone') ?: 'BUSINESS_SUPPORT_PHONE' }}, and {{ config('business.mailing_address') ?: 'BUSINESS_MAILING_ADDRESS' }}.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Eligibility for refunds</h2>
                    <p class="mt-2">Customers may request a refund review when a duplicate payment is made, the wrong amount is charged, the purchased service cannot be started, or the delivered service materially differs from the published package or approved custom quote. Approved refunds are returned to the original payment method.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">When refunds are limited</h2>
                    <p class="mt-2">Refunds are generally not issued after a package has been substantially delivered or where delays are caused by missing customer information, inaccessible social-media accounts, changed third-party platform rules, or customer-requested pauses. If only part of a service has been delivered, a partial refund or store credit may be offered based on the remaining undelivered scope.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Cancellation requests</h2>
                    <p class="mt-2">Customers should contact support as quickly as possible if they need to cancel an order. If work has not started, we may cancel the order and issue a full refund. If fulfillment has already started, we will review whether a partial refund or credit is appropriate.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">How to request help</h2>
                    <p class="mt-2">Before opening a payment dispute, customers should contact support with the order number, account email, and a short explanation of the issue so we can review the order and attempt to resolve it promptly. This does not limit a customer's legal rights to raise a legitimate dispute where required.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Refund review window</h2>
                    <p class="mt-2">Refund and billing issues should be reported within 7 calendar days after the payment date or within 7 calendar days after the customer becomes aware of a delivery issue, whichever is earlier. We may still review older requests where required by law or payment-network rules.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Coverage of all payment flows</h2>
                    <p class="mt-2">These terms apply to standard package checkout, direct custom amount payments, and reusable payment-link payments. Each payment page should describe the service being purchased, and refund decisions are reviewed against that published or quoted scope.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Customer responsibility</h2>
                    <p class="mt-2">Customers are responsible for reviewing package details, pricing, delivery timelines, payment amounts, and service scope before submitting payment. If anything is unclear, contact support before paying.</p>
                </div>
            </div>
        </section>
    </div>
</x-layouts.storefront>
