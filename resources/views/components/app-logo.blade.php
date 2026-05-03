@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Telligent Store" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md overflow-hidden">
            <img src="{{ asset('brand/telligent-mark.svg') }}" alt="Telligent Store" class="size-8 rounded-md" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Telligent Store" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md overflow-hidden">
            <img src="{{ asset('brand/telligent-mark.svg') }}" alt="Telligent Store" class="size-8 rounded-md" />
        </x-slot>
    </flux:brand>
@endif
