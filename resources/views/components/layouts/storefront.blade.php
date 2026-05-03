<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="store-shell text-slate-900 antialiased">
        <div class="mx-auto max-w-7xl px-4 py-6 md:px-6 lg:px-8">
            <x-public-header />
            {{ $slot }}
            <x-public-footer />
        </div>
        @fluxScripts
    </body>
</html>
