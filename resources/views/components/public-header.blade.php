<header class="store-card sticky top-4 z-20 mb-8 px-6 py-5 backdrop-blur md:flex md:items-center md:justify-between md:gap-6" data-mobile-nav>
    <div class="flex items-center justify-between gap-4 md:min-w-0">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('brand/telligent-mark.svg') }}" alt="Telligent Store" class="size-11 rounded-2xl">
            <div>
                <p class="text-lg font-extrabold tracking-tight text-slate-950">{{ config('business.storefront_name') }}</p>
                <p class="text-xs uppercase tracking-[0.24em] text-slate-500">{{ config('business.legal_name') }}</p>
            </div>
        </a>

        <button
            type="button"
            class="inline-flex size-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 transition hover:border-slate-950 hover:text-slate-950 md:hidden"
            data-mobile-nav-toggle
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <path d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>
    </div>

    <nav class="hidden gap-2 pt-4 text-sm font-semibold text-slate-600 md:flex md:flex-wrap md:items-center md:justify-end md:pt-0" data-mobile-nav-menu>
        <a href="{{ route('home') }}" class="block rounded-full px-3 py-2 transition hover:bg-slate-100 hover:text-slate-950">Home</a>
        <a href="{{ route('about') }}" class="block rounded-full px-3 py-2 transition hover:bg-slate-100 hover:text-slate-950">About</a>
        <a href="{{ route('contact') }}" class="block rounded-full px-3 py-2 transition hover:bg-slate-100 hover:text-slate-950">Contact</a>
        @auth
            <a href="{{ route('dashboard') }}" class="block rounded-full bg-slate-950 px-4 py-2 text-center text-white transition hover:bg-sky-600">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="block rounded-full bg-slate-100 px-4 py-2 text-center text-slate-900 transition hover:bg-slate-200 hover:text-slate-950 md:me-0">Login</a>
            <a href="{{ route('register') }}" class="mt-1 block rounded-full bg-slate-950 px-4 py-2 text-center text-white transition hover:bg-sky-600 md:mt-0">Create account</a>
        @endauth
    </nav>
</header>
