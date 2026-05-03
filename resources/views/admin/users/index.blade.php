<x-layouts::app :title="__('Users')">
    <div class="space-y-6 p-4 md:p-8">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Users</h1>
            <p class="mt-2 text-sm text-slate-600">Review customer accounts without showing admin users in this list.</p>
        </div>

        <form method="GET" class="admin-card p-4 md:p-5">
            <div class="grid gap-4 md:grid-cols-[1.4fr_1fr_1fr_auto_auto] md:items-end">
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Search users</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm">
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Date from</span>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm">
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-slate-700">Date to</span>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm">
                </label>
                <button type="submit" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Filter</button>
                <a href="{{ route('admin.users.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-center text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:text-slate-950">Reset</a>
            </div>
        </form>

        <div class="admin-card overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">User</th>
                        <th class="px-6 py-3 font-semibold">Role</th>
                        <th class="px-6 py-3 font-semibold">Orders</th>
                        <th class="px-6 py-3 font-semibold">Payments</th>
                        <th class="px-6 py-3 font-semibold"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->role->label() }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->orders_count }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $user->payments_count }}</td>
                            <td class="px-6 py-4 text-right"><a href="{{ route('admin.users.show', $user) }}" class="font-semibold text-sky-600">Open</a></td>
                        </tr>
                    @endforeach
                    @if ($users->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">No customer accounts found for the selected filters.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>
</x-layouts::app>
