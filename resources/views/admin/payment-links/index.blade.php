<x-layouts::app :title="__('Payment Links')">
    <div class="space-y-6 p-4 md:p-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-950">Payment Links</h1>
                <p class="mt-2 text-sm text-slate-600">Reusable custom payment pages that can be shared with multiple customers.</p>
            </div>
            <a href="{{ route('admin.payment-links.create') }}" class="rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-sky-600">Create payment link</a>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('status') }}</div>
        @endif

        <div
            class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/40 px-4"
            data-remove-payment-link-modal
            aria-hidden="true"
        >
            <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
                <h2 class="text-xl font-extrabold tracking-tight text-slate-950">Remove payment link?</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">This will delete the reusable payment link. Past orders and payments will remain intact.</p>
                <div class="mt-6 flex items-center justify-end gap-3">
                    <button
                        type="button"
                        class="rounded-full border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:text-slate-950"
                        data-remove-payment-link-cancel
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="rounded-full bg-rose-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700"
                        data-remove-payment-link-confirm
                    >
                        Remove link
                    </button>
                </div>
            </div>
        </div>

        <div class="admin-card overflow-hidden">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Title</th>
                        <th class="px-6 py-3 font-semibold">Amount</th>
                        <th class="px-6 py-3 font-semibold">Uses</th>
                        <th class="px-6 py-3 font-semibold">Link</th>
                        <th class="px-6 py-3 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @foreach ($paymentLinks as $paymentLink)
                        @php($paymentLinkUrl = route('payments.link.show', $paymentLink))
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $paymentLink->title }}</td>
                            <td class="px-6 py-4 text-slate-600">${{ number_format($paymentLink->amount, 2) }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $paymentLink->orders_count }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                <a href="{{ $paymentLinkUrl }}" target="_blank" class="break-all text-sky-600 hover:text-sky-700">
                                    {{ $paymentLinkUrl }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-3">
                                    <button
                                        type="button"
                                        class="rounded-full bg-sky-50 px-4 py-2 text-sm font-semibold text-sky-700 transition hover:bg-sky-100"
                                        data-copy-link
                                        data-copy-value="{{ $paymentLinkUrl }}"
                                        data-copy-label-default="Copy link"
                                        data-copy-label-success="Copied"
                                    >
                                        Copy link
                                    </button>
                                    <form method="POST" action="{{ route('admin.payment-links.destroy', $paymentLink) }}" data-remove-payment-link-form>
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            class="rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100"
                                            data-remove-payment-link-trigger
                                        >
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if ($paymentLinks->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">No payment links found yet.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{ $paymentLinks->links() }}
    </div>
</x-layouts::app>
