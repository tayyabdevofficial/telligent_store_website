@props([
    'eyebrow',
    'title',
    'description',
])

<section class="store-card px-6 py-10 md:px-10 md:py-12">
    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-sky-600">{{ $eyebrow }}</p>
    <h1 class="mt-4 max-w-4xl text-4xl font-extrabold tracking-tight text-slate-950 md:text-5xl">{{ $title }}</h1>
    <p class="mt-5 max-w-3xl text-base leading-7 text-slate-600">{{ $description }}</p>
</section>
