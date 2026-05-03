<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialPlatform;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlatformController extends Controller
{
    public function index(): View
    {
        $platforms = SocialPlatform::query()
            ->withCount(['packages', 'orders'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.platforms.index', compact('platforms'));
    }

    public function create(): View
    {
        return view('admin.platforms.form', [
            'platform' => new SocialPlatform([
                'is_active' => true,
                'accent_color' => '#0ea5e9',
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePlatform($request);
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['name']);

        SocialPlatform::create($validated);

        return redirect()->route('admin.platforms.index')
            ->with('status', 'Platform created successfully.');
    }

    public function edit(SocialPlatform $platform): View
    {
        return view('admin.platforms.form', compact('platform'));
    }

    public function update(Request $request, SocialPlatform $platform): RedirectResponse
    {
        $validated = $this->validatePlatform($request, $platform->id);
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['name']);

        $platform->update($validated);

        return redirect()->route('admin.platforms.index')
            ->with('status', 'Platform updated successfully.');
    }

    protected function validatePlatform(Request $request, ?int $platformId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:social_platforms,slug,'.$platformId],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'accent_color' => ['required', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'sort_order' => (int) $request->integer('sort_order'),
        ];
    }
}
