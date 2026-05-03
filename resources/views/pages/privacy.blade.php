<x-layouts.storefront :title="'Privacy Policy'">
    <div class="space-y-8">
        <x-public-page-hero
            eyebrow="Privacy policy"
            title="How customer, order, and payment data is handled on the platform."
            :description="'This policy explains what information is collected, why it is used, how it is stored, and the limits of payment data handled through '.config('business.storefront_name').', operated by '.config('business.legal_name').'.'"
        />

        <section class="store-card p-6 md:p-8">
            <div class="space-y-6 text-sm leading-7 text-slate-600">
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Business identity</h2>
                    <p class="mt-2">{{ config('business.storefront_name') }} operates under {{ config('business.legal_name') }}. References on this website to the platform, business, website, we, or our include the {{ config('business.storefront_name') }} brand as operated under that corporate structure. The business can be contacted at {{ config('business.support_email') }}, {{ config('business.support_phone') ?: 'BUSINESS_SUPPORT_PHONE' }}, and {{ config('business.mailing_address') ?: 'BUSINESS_MAILING_ADDRESS' }}.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Information collected</h2>
                    <p class="mt-2">We may collect customer name, email address, phone number when provided, social-media page or profile details, order-related instructions, custom payment details, account registration data, and records needed for payment processing and service administration.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">How information is used</h2>
                    <p class="mt-2">Collected information is used to create customer accounts, process orders, confirm payments, communicate about service progress, provide support, maintain payment history, reduce fraud risk, and manage internal reporting on the admin side.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Payment handling</h2>
                    <p class="mt-2">Payments are processed through Stripe. Sensitive payment credentials such as full card details are handled by Stripe Checkout and are not intended to be stored directly by this application. Our system may store payment-related references such as payment status, session identifiers, payment method labels, and webhook payload data needed for reconciliation and support.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Guest checkout and account data</h2>
                    <p class="mt-2">This website supports both guest checkout and registered accounts. Guest order data may still be stored for order tracking, payment verification, dispute prevention, and historical reporting. Registered users may also have ongoing account records, order history, and payment history stored in the system.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Sharing and disclosure</h2>
                    <p class="mt-2">Information is not intended to be sold as a standalone product. Data may be shared only when operationally necessary, such as with payment providers, hosting services, technical infrastructure, compliance requests, fraud investigations, or lawful authority requests.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Retention</h2>
                    <p class="mt-2">Order, customer, account, and payment records may be retained for operational continuity, business history, support review, fraud prevention, compliance, and accounting purposes unless deletion is legally required or explicitly supported by the platform.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Security limitations</h2>
                    <p class="mt-2">Reasonable efforts may be used to protect stored information, but no website or third-party platform can guarantee absolute security. By using the service, the customer understands that internet-based systems always carry some level of technical risk.</p>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-950">Policy updates</h2>
                    <p class="mt-2">This privacy policy may be updated at any time to reflect business, legal, operational, or technical changes. Continued use of the website after an update means the customer accepts the revised policy.</p>
                </div>
            </div>
        </section>
    </div>
</x-layouts.storefront>
