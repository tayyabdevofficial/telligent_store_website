<x-layouts.storefront :title="'Terms & Conditions'">
    <div class="space-y-8">
        <x-public-page-hero
            eyebrow="Terms & conditions"
            title="Core rules for using the website and purchasing digital service packages."
            :description="'These terms set expectations around service scope, payment confirmation, customer responsibility, and third-party platform limitations for '.config('business.storefront_name').', operated by '.config('business.legal_name').'.'"
        />

        <section class="store-card p-6 md:p-8">
            <div class="space-y-6 text-sm leading-7 text-slate-600">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Business identity</h2>
                    <p class="mt-2">{{ config('business.storefront_name') }} is a service brand operating under {{ config('business.legal_name') }}. By using this website, the customer understands that the storefront, payment pages, support process, and legal terms are provided under that business structure. Support contact details and the mailing address published on the website apply to these terms.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Acceptance of terms</h2>
                    <p class="mt-2">By accessing this website, creating an account, submitting an order, or paying through checkout or a custom payment page, the customer agrees to these terms and all related legal pages published on the website.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Service scope</h2>
                    <p class="mt-2">Services offered through this website relate to digital promotion, monetization support, engagement campaigns, social-media growth packages, and custom payment requests. Unless explicitly agreed otherwise in writing, each order is limited to the package or payment request selected by the customer and described on the relevant product or payment page.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Order responsibility</h2>
                    <p class="mt-2">Customers are responsible for entering accurate names, email addresses, page references, account details, and any other required information. If incorrect or incomplete information is provided, the service may be delayed, limited, or treated as customer error.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Payment confirmation</h2>
                    <p class="mt-2">A payment submitted through the website is treated as final confirmation that the customer wants the service to proceed. Customers should only pay when they understand the offer and are fully ready to move forward. Payment must not be treated as a temporary hold, trial action, or reversible booking.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Refunds and disputes</h2>
                    <p class="mt-2">All payments are subject to the published refund policy. Customers should contact support first if there is a billing or delivery problem so we can review the order and attempt resolution. Nothing in these terms removes a customer's right to raise a legitimate payment dispute or chargeback under applicable law or payment-network rules.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Platform limitations</h2>
                    <p class="mt-2">Service delivery may be affected by changes on third-party platforms such as Facebook, Instagram, YouTube, TikTok, or payment-provider rules. We do not control external platform policies, algorithm changes, content moderation actions, account restrictions, or system outages.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">No guarantee of external platform results</h2>
                    <p class="mt-2">While services are offered in good faith, no guarantee is made that a third-party platform will approve monetization, maintain visibility, preserve posted content, or continue delivering the same environment over time. External platform outcomes remain outside direct control.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Account and admin rights</h2>
                    <p class="mt-2">The website owner may update packages, prices, payment methods, legal pages, and admin-side controls at any time. Accounts or orders may also be limited, reviewed, or refused where misuse, fraud, abuse, or policy concerns are identified.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Liability limits</h2>
                    <p class="mt-2">To the maximum extent allowed, liability for indirect loss, platform-side decisions, customer-side mistakes, business interruption, account limitations, or third-party system actions is excluded. Use of the website is at the customer's own decision and risk.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Updates to terms</h2>
                    <p class="mt-2">These terms may be revised at any time. Continued use of the website after changes are published means the customer accepts the updated terms.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Business contact details</h2>
                    <p class="mt-2">Support email: {{ config('business.support_email') }}. Support phone: {{ config('business.support_phone') ?: 'BUSINESS_SUPPORT_PHONE' }}. Mailing address: {{ config('business.mailing_address') ?: 'BUSINESS_MAILING_ADDRESS' }}. Business hours: {{ config('business.business_hours') }}.</p>
                </div>
            </div>
        </section>
    </div>
</x-layouts.storefront>
