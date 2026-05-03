<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $payments = Payment::query()
            ->with(['order.package.platform', 'order.paymentLink', 'user'])
            ->when(
                $request->filled('email'),
                fn ($query) => $query->where('customer_email', 'like', '%'.$request->string('email')->trim().'%')
            )
            ->when(
                $request->filled('status'),
                fn ($query) => $query->where('status', $request->string('status'))
            )
            ->when(
                $request->filled('date_from'),
                fn ($query) => $query->whereDate('created_at', '>=', $request->string('date_from')->toString())
            )
            ->when(
                $request->filled('date_to'),
                fn ($query) => $query->whereDate('created_at', '<=', $request->string('date_to')->toString())
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = PaymentStatus::cases();

        return view('admin.payments.index', compact('payments', 'statuses'));
    }

    public function show(Payment $payment): View
    {
        $payment->load(['order.package.platform', 'order.paymentLink', 'user']);

        return view('admin.payments.show', compact('payment'));
    }
}
