<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="store-shell text-slate-900 antialiased">
        {{ $slot }}
    </body>
</html>
