<x-layouts::app :title="$platform->exists ? __('Edit Platform') : __('Create Platform')">
    <div class="max-w-4xl p-4 md:p-8">
        <div class="admin-card p-6 md:p-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">{{ $platform->exists ? 'Edit platform' : 'Create platform' }}</h1>
            <form method="POST" action="{{ $platform->exists ? route('admin.platforms.update', $platform) : route('admin.platforms.store') }}" class="mt-8 space-y-5">
                @csrf
                @if ($platform->exists) @method('PUT') @endif
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Name</span><input type="text" name="name" value="{{ old('name', $platform->name) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required></label>
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Slug</span><input type="text" name="slug" value="{{ old('slug', $platform->slug) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm"></label>
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Icon</span><input type="text" name="icon" value="{{ old('icon', $platform->icon) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm"></label>
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Accent color</span><input type="text" name="accent_color" value="{{ old('accent_color', $platform->accent_color) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required></label>
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Sort order</span><input type="number" name="sort_order" value="{{ old('sort_order', $platform->sort_order) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm"></label>
                    <label class="flex items-center gap-3 pt-8 text-sm font-semibold text-slate-700"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $platform->is_active)) class="rounded border-slate-300"> Active on website</label>
                    <label class="block md:col-span-2"><span class="mb-2 block text-sm font-semibold text-slate-700">Description</span><textarea name="description" rows="5" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm">{{ old('description', $platform->description) }}</textarea></label>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Save platform</button>
                    <a href="{{ route('admin.platforms.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
