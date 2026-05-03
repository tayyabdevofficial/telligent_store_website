<x-layouts::app :title="__('Platforms')">
    <div class="space-y-6 p-4 md:p-8">
        <div class="flex items-center justify-between gap-4">
            <div><h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Platforms</h1><p class="mt-2 text-sm text-slate-600">Create and organize the social networks available on the storefront.</p></div>
            <a href="{{ route('admin.platforms.create') }}" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Add platform</a>
        </div>
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
        <div class="admin-card overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-slate-500"><tr><th class="px-6 py-3 font-semibold">Platform</th><th class="px-6 py-3 font-semibold">Packages</th><th class="px-6 py-3 font-semibold">Orders</th><th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold"></th></tr></thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($platforms as $platform)
                        <tr>
                            <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="flex size-10 items-center justify-center rounded-xl text-white" style="background-color: {{ $platform->accent_color }}"><x-social-platform-icon :platform="$platform->name" class="size-5" /></div><div><p class="font-semibold text-slate-900">{{ $platform->name }}</p><p class="text-xs text-slate-500">{{ $platform->slug }}</p></div></div></td>
                            <td class="px-6 py-4 text-slate-600">{{ $platform->packages_count }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $platform->orders_count }}</td>
                            <td class="px-6 py-4"><span class="rounded-full {{ $platform->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} px-3 py-1 text-xs font-semibold">{{ $platform->is_active ? 'Active' : 'Hidden' }}</span></td>
                            <td class="px-6 py-4 text-right"><a href="{{ route('admin.platforms.edit', $platform) }}" class="font-semibold text-sky-600 hover:text-sky-700">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $platforms->links() }}
    </div>
</x-layouts::app>
