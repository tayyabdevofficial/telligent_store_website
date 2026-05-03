@props([
    'platform',
    'class' => 'size-6',
])

@php
    $value = strtolower(trim($platform));
@endphp

@switch($value)
    @case('facebook')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M13.5 21v-7h2.4l.6-3h-3V9.2c0-.9.4-1.7 1.8-1.7H16.7V4.9c-.3 0-1.2-.1-2.3-.1-2.4 0-4 1.5-4 4.2V11H8v3h2.4v7h3.1Z"/>
        </svg>
        @break
    @case('instagram')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <rect x="4" y="4" width="16" height="16" rx="4.5" stroke="currentColor" stroke-width="2"/>
            <circle cx="12" cy="12" r="3.6" stroke="currentColor" stroke-width="2"/>
            <circle cx="17.2" cy="6.8" r="1.1" fill="currentColor"/>
        </svg>
        @break
    @case('youtube')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M21.6 8.3c-.2-1-.9-1.8-1.9-2-1.8-.4-7.7-.4-7.7-.4s-5.9 0-7.7.4c-1 .2-1.7 1-1.9 2-.4 1.8-.4 3.7-.4 3.7s0 1.9.4 3.7c.2 1 .9 1.8 1.9 2 1.8.4 7.7.4 7.7.4s5.9 0 7.7-.4c1-.2 1.7-1 1.9-2 .4-1.8.4-3.7.4-3.7s0-1.9-.4-3.7ZM10.2 15.4V8.6l5.8 3.4-5.8 3.4Z"/>
        </svg>
        @break
    @case('tiktok')
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M14.8 4c.6 1.8 1.9 3 3.7 3.4v2.4a6.9 6.9 0 0 1-3.3-.9v5.6a4.8 4.8 0 1 1-4.8-4.8c.3 0 .6 0 .9.1v2.5a2.3 2.3 0 1 0 1.4 2.2V4h2.1Z"/>
        </svg>
        @break
    @default
        <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
            <path d="M7 12h10M12 7v10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
@endswitch
