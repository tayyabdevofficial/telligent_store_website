<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentLinkRequest;
use App\Models\PaymentLink;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class PaymentLinkController extends Controller
{
    public function index(): View
    {
        $paymentLinks = PaymentLink::query()
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        return view('admin.payment-links.index', compact('paymentLinks'));
    }

    public function create(): View
    {
        return view('admin.payment-links.create');
    }

    public function store(PaymentLinkRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 2;

        while (PaymentLink::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        PaymentLink::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'slug' => $slug,
            'amount' => $validated['amount'],
            'currency' => 'usd',
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.payment-links.index')
            ->with('status', 'Payment link created successfully.');
    }

    public function destroy(PaymentLink $paymentLink): RedirectResponse
    {
        $paymentLink->delete();

        return redirect()
            ->route('admin.payment-links.index')
            ->with('status', 'Payment link removed successfully.');
    }
}
