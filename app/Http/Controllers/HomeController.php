<?php

namespace App\Http\Controllers;

use App\Models\ServicePackage;
use App\Models\SocialPlatform;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $platforms = SocialPlatform::query()
            ->with([
                'packages' => fn ($query) => $query->active()->orderBy('sort_order')->orderBy('price'),
            ])
            ->withCount([
                'packages as active_packages_count' => fn ($query) => $query->active(),
            ])
            ->active()
            ->orderBy('sort_order')
            ->get();

        $featuredPackages = ServicePackage::query()
            ->with('platform')
            ->active()
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $stats = [
            'platforms' => $platforms->count(),
            'services' => ServicePackage::query()->active()->count(),
            'starting_at' => ServicePackage::query()->active()->min('price') ?? 0,
        ];

        return view('home', compact('platforms', 'featuredPackages', 'stats'));
    }
}
