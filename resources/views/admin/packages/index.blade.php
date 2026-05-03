<x-layouts::app :title="__('Packages')">
    <div class="space-y-6 p-4 md:p-8">
        <div class="flex items-center justify-between gap-4">
            <div><h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Packages</h1><p class="mt-2 text-sm text-slate-600">Manage package pricing, visibility, and social-media service types.</p></div>
            <a href="{{ route('admin.packages.create') }}" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Add package</a>
        </div>
        @if (session('status'))<div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>@endif
        <div class="admin-card overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-slate-500"><tr><th class="px-6 py-3 font-semibold">Package</th><th class="px-6 py-3 font-semibold">Platform</th><th class="px-6 py-3 font-semibold">Price</th><th class="px-6 py-3 font-semibold">Status</th><th class="px-6 py-3 font-semibold"></th></tr></thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($packages as $package)
                        <tr>
                            <td class="px-6 py-4"><p class="font-semibold text-slate-900">{{ $package->name }}</p><p class="text-xs text-slate-500">{{ $package->service_type }}</p></td>
                            <td class="px-6 py-4 text-slate-600">{{ $package->platform?->name }}</td>
                            <td class="px-6 py-4 text-slate-600">${{ number_format($package->price, 2) }}</td>
                            <td class="px-6 py-4"><span class="rounded-full {{ $package->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} px-3 py-1 text-xs font-semibold">{{ $package->is_active ? 'Active' : 'Hidden' }}</span></td>
                            <td class="px-6 py-4 text-right"><a href="{{ route('admin.packages.edit', $package) }}" class="font-semibold text-sky-600">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $packages->links() }}
    </div>
</x-layouts::app>
