<x-layouts::app :title="$package->exists ? __('Edit Package') : __('Create Package')">
    <div class="max-w-5xl p-4 md:p-8">
        <div class="admin-card p-6 md:p-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">{{ $package->exists ? 'Edit package' : 'Create package' }}</h1>
            <form method="POST" action="{{ $package->exists ? route('admin.packages.update', $package) : route('admin.packages.store') }}" class="mt-8 space-y-5">
                @csrf
                @if ($package->exists) @method('PUT') @endif
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Platform</span><select name="social_platform_id" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm">@foreach ($platforms as $platform)<option value="{{ $platform->id }}" @selected(old('social_platform_id', $package->social_platform_id) == $platform->id)>{{ $platform->name }}</option>@endforeach</select></label>
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Service type</span><input type="text" name="service_type" value="{{ old('service_type', $package->service_type) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required></label>
                    <label class="block md:col-span-2"><span class="mb-2 block text-sm font-semibold text-slate-700">Name</span><input type="text" name="name" value="{{ old('name', $package->name) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required></label>
                    <label class="block md:col-span-2"><span class="mb-2 block text-sm font-semibold text-slate-700">Slug</span><input type="text" name="slug" value="{{ old('slug', $package->slug) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm"></label>
                    <label class="block md:col-span-2"><span class="mb-2 block text-sm font-semibold text-slate-700">Customer-facing description</span><textarea name="description" rows="4" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required>{{ old('description', $package->description) }}</textarea></label>
                    <label class="block md:col-span-2"><span class="mb-2 block text-sm font-semibold text-slate-700">Delivery timeline</span><input type="text" name="delivery_timeline" value="{{ old('delivery_timeline', $package->delivery_timeline) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" placeholder="Example: Starts within 24 hours and completes within 3 to 7 business days." required></label>
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Price</span><input type="number" step="0.01" name="price" value="{{ old('price', $package->price) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required></label>
                    <label class="block"><span class="mb-2 block text-sm font-semibold text-slate-700">Sort order</span><input type="number" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm"></label>
                    <label class="flex items-center gap-3 text-sm font-semibold text-slate-700"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $package->is_active)) class="rounded border-slate-300"> Active</label>
                    <label class="flex items-center gap-3 text-sm font-semibold text-slate-700"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $package->is_featured)) class="rounded border-slate-300"> Featured</label>
                </div>
                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Save package</button>
                    <a href="{{ route('admin.packages.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
