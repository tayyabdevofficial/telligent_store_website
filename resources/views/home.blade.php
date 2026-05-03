<x-layouts.storefront :title="__('Social Media Growth Services')">
    <div>
        <section class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <div class="store-card overflow-hidden px-6 py-8 md:px-10 md:py-12">
                <p class="text-sm font-semibold uppercase tracking-[0.28em] text-sky-600">Lightweight storefront, heavy admin control</p>
                <h1 class="mt-4 max-w-3xl text-4xl font-extrabold tracking-tight text-slate-950 md:text-6xl">Sell social media promotion and monetization packages from one optimized platform.</h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600 md:text-lg">{{ config('business.storefront_name') }} works under {{ config('business.legal_name') }} and manages Facebook, Instagram, YouTube, TikTok, and future services with package-level pricing, detailed service descriptions, Stripe payments, role-based access, order history, customer accounts, and admin-side reporting.</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#services" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Explore services</a>
                    <a href="{{ route('register') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:text-slate-950">Create customer account</a>
                </div>
            </div>

            <div class="store-card overflow-hidden">
                <div class="relative h-full min-h-[420px]">
                    <img src="{{ asset('images/hero-social-team.jpg') }}" alt="Professional social media marketing team reviewing growth dashboards" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(15,23,42,0.08),rgba(15,23,42,0.78))]"></div>
                    <div class="relative flex h-full flex-col justify-between p-6 md:p-8">
                        <div class="flex items-start justify-between gap-4">
                            <div class="rounded-full bg-white/14 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-white backdrop-blur">Professional campaigns</div>
                            <img src="{{ asset('brand/telligent-mark.svg') }}" alt="" class="size-14 rounded-2xl shadow-lg shadow-slate-900/25">
                        </div>

                        <div class="max-w-lg rounded-3xl bg-slate-950/62 p-5 text-sm leading-6 text-slate-100 backdrop-blur">
                            Scale pages, boost visibility, and manage monetization-focused services through {{ config('business.storefront_name') }}, a brand working under {{ config('business.legal_name') }}.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="mt-16 space-y-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Core services</p>
                <h2 class="section-title mt-2">Professional social-growth solutions for creators, brands, and page owners</h2>
                <p class="mt-3 max-w-3xl text-sm leading-6 text-slate-600">Choose from packaged growth services designed for reach, engagement, monetization support, and campaign momentum across major social platforms.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <article class="store-card p-6">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-sky-100 text-sky-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-7" aria-hidden="true">
                            <path d="M4 19h16" stroke-linecap="round" />
                            <path d="M7 16V9" stroke-linecap="round" />
                            <path d="M12 16V5" stroke-linecap="round" />
                            <path d="M17 16v-3" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold tracking-tight text-slate-950">Post Promotion</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Boost post visibility for launches, campaigns, announcements, and branded content with fast-turn promotion packages.</p>
                </article>

                <article class="store-card p-6">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-7" aria-hidden="true">
                            <path d="M5 12.5 10 17l9-10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 3c4.2 0 7 2.6 7 6.4 0 6.1-7 11.6-7 11.6S5 15.5 5 9.4C5 5.6 7.8 3 12 3Z" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold tracking-tight text-slate-950">Page Monetization Support</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Structured campaigns built to strengthen audience signals and improve readiness for monetization-focused social pages.</p>
                </article>

                <article class="store-card p-6">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-rose-100 text-rose-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-7" aria-hidden="true">
                            <path d="M4 18V8.5a2.5 2.5 0 0 1 2.5-2.5h11A2.5 2.5 0 0 1 20 8.5V18" stroke-linecap="round" />
                            <path d="M8 18V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V18" stroke-linecap="round" />
                            <path d="M3 18h18" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold tracking-tight text-slate-950">Facebook &amp; Instagram Growth</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Growth services for pages, profiles, reels, and branded content built to increase traction across Meta platforms.</p>
                </article>

                <article class="store-card p-6">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-amber-100 text-amber-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-7" aria-hidden="true">
                            <path d="m9 8 7 4-7 4V8Z" stroke-linejoin="round" />
                            <rect x="3.5" y="5" width="17" height="14" rx="3" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold tracking-tight text-slate-950">Views, Subscribers, and Comments</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Order performance-focused services for YouTube and Facebook including views, subscribers, comments, and engagement boosts.</p>
                </article>

                <article class="store-card p-6">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-violet-100 text-violet-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-7" aria-hidden="true">
                            <path d="M12 3v18" stroke-linecap="round" />
                            <path d="M17.5 7.5A4.5 4.5 0 0 0 13 3h-2a3.5 3.5 0 0 0 0 7h2a3.5 3.5 0 0 1 0 7h-2A4.5 4.5 0 0 1 6.5 12.5" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold tracking-tight text-slate-950">Custom Payment Requests</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Use reusable payment links or flexible custom-amount checkout pages for tailored campaign orders and manual billing.</p>
                </article>

                <article class="store-card p-6">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-slate-200 text-slate-700">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-7" aria-hidden="true">
                            <path d="M4 7h16" stroke-linecap="round" />
                            <path d="M7 12h5" stroke-linecap="round" />
                            <path d="M7 16h8" stroke-linecap="round" />
                            <rect x="3" y="4" width="18" height="16" rx="3" />
                        </svg>
                    </div>
                    <h3 class="mt-5 text-xl font-extrabold tracking-tight text-slate-950">Managed Order Handling</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Every order routes through an admin-managed backend with payment tracking, package control, and customer history visibility.</p>
                </article>
            </div>
        </section>

        <section id="packages" class="mt-16">
            <div class="mb-8 space-y-3">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Featured services</p>
                    <h2 class="section-title mt-2">Ready-to-sell packages for fast launch</h2>
                </div>
                <p class="max-w-2xl text-sm leading-6 text-slate-600">Each package includes structured pricing, service scope, and a fast checkout flow that works for guests and logged-in customers.</p>
            </div>

            <div class="grid gap-5 lg:grid-cols-3">
                @foreach ($featuredPackages as $package)
                    <article class="store-card flex h-full flex-col p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.22em]" style="color: {{ $package->platform->accent_color }}">{{ $package->platform->name }}</p>
                                <h3 class="mt-2 text-xl font-extrabold tracking-tight text-slate-950">{{ $package->name }}</h3>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $package->service_type }}</span>
                        </div>

                        <div class="mt-6 flex items-end gap-2">
                            <span class="text-4xl font-extrabold tracking-tight text-slate-950">${{ number_format($package->price, 2) }}</span>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-slate-600">{{ $package->description }}</p>
                        <p class="mt-3 text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">{{ $package->delivery_timeline }}</p>

                        <div class="mt-auto pt-8">
                            <a href="{{ route('checkout.create', $package) }}" class="inline-flex w-full items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">
                                Order now
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section id="platforms" class="mt-16 space-y-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">Platforms</p>
                <h2 class="section-title mt-2">Organized by social network, manageable from admin</h2>
            </div>

            <div class="grid gap-5 lg:grid-cols-2">
                @foreach ($platforms as $platform)
                    <section class="store-card p-6">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="flex size-14 items-center justify-center rounded-2xl text-white" style="background-color: {{ $platform->accent_color }}">
                                    <x-social-platform-icon :platform="$platform->name" class="size-7" />
                                </div>
                                <div>
                                    <h3 class="text-2xl font-extrabold tracking-tight text-slate-950">{{ $platform->name }}</h3>
                                    <p class="text-sm text-slate-500">{{ $platform->active_packages_count }} active packages</p>
                                </div>
                            </div>
                        </div>

                        <p class="mt-4 text-sm leading-6 text-slate-600">{{ $platform->description }}</p>

                        <div class="mt-6 grid gap-4 md:grid-cols-2">
                            @foreach ($platform->packages->take(4) as $package)
                                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">{{ $package->service_type }}</p>
                                    <h4 class="mt-2 text-base font-bold text-slate-950">{{ $package->name }}</h4>
                                    <p class="mt-2 text-sm text-slate-600">${{ number_format($package->price, 2) }}</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $package->description }}</p>
                                    <a href="{{ route('checkout.create', $package) }}" class="mt-4 justify-center w-full inline-flex rounded-full bg-slate-950 px-4 py-2 text-xs font-semibold text-white transition hover:bg-sky-600">
                                        Order now
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        </section>
    </div>
</x-layouts.storefront>
