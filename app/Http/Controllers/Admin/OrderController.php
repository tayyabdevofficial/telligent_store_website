<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->with(['package.platform', 'paymentLink', 'payments', 'user'])
            ->when(
                $request->filled('email'),
                fn ($query) => $query->where('customer_email', 'like', '%'.$request->string('email')->trim().'%')
            )
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
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

        $statuses = OrderStatus::cases();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order): View
    {
        $order->load(['package.platform', 'paymentLink', 'payments', 'user', 'items']);

        $statuses = OrderStatus::cases();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:'.collect(OrderStatus::cases())->pluck('value')->implode(',')],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)
            ->with('status', 'Order updated successfully.');
    }
}
