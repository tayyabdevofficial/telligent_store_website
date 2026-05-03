<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->where('role', '!=', UserRole::Admin->value)
            ->withCount(['orders', 'payments'])
            ->when(
                $request->filled('search'),
                fn ($query) => $query->where(function ($searchQuery) use ($request) {
                    $term = $request->string('search')->trim()->toString();

                    $searchQuery
                        ->where('name', 'like', '%'.$term.'%')
                        ->orWhere('email', 'like', '%'.$term.'%');
                })
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

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        abort_if($user->isAdmin(), 404);

        $user->load(['orders.package.platform', 'orders.paymentLink', 'payments']);

        return view('admin.users.show', compact('user'));
    }
}
