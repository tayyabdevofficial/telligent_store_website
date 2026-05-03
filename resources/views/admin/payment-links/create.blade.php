<x-layouts::app :title="__('Create Payment Link')">
    <div class="max-w-4xl p-4 md:p-8">
        <div class="admin-card p-6 md:p-8">
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Create payment link</h1>
            <p class="mt-2 text-sm leading-6 text-slate-600">Create a reusable custom payment page that customers can open and pay multiple times.</p>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.payment-links.store') }}" class="mt-8 grid gap-5 md:grid-cols-2">
                @csrf
                <label class="block md:col-span-2">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Payment title</span>
                    <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required>
                </label>
                <label class="block md:col-span-2">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Customer-facing description</span>
                    <textarea name="description" rows="4" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required>{{ old('description') }}</textarea>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Amount (USD)</span>
                    <input type="number" name="amount" value="{{ old('amount') }}" min="1" step="0.01" class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm" required>
                </label>
                <div></div>
                <div class="md:col-span-2 flex items-center gap-3">
                    <button type="submit" class="rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Create link</button>
                    <a href="{{ route('admin.payment-links.index') }}" class="rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
