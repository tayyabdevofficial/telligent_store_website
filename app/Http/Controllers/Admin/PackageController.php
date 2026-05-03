<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use App\Models\SocialPlatform;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = ServicePackage::query()
            ->with('platform')
            ->latest()
            ->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    public function create(): View
    {
        return view('admin.packages.form', [
            'package' => new ServicePackage([
                'is_active' => true,
            ]),
            'platforms' => SocialPlatform::query()->active()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePackage($request);
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['name']);

        ServicePackage::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('status', 'Package created successfully.');
    }

    public function edit(ServicePackage $package): View
    {
        return view('admin.packages.form', [
            'package' => $package,
            'platforms' => SocialPlatform::query()->active()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, ServicePackage $package): RedirectResponse
    {
        $validated = $this->validatePackage($request, $package->id);
        $validated['slug'] = Str::slug($validated['slug'] ?: $validated['name']);

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('status', 'Package updated successfully.');
    }

    protected function validatePackage(Request $request, ?int $packageId = null): array
    {
        return $request->validate([
            'social_platform_id' => ['required', 'exists:social_platforms,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:service_packages,slug,'.$packageId],
            'service_type' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
            'delivery_timeline' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]) + [
            'is_active' => $request->boolean('is_active'),
            'is_featured' => $request->boolean('is_featured'),
            'sort_order' => (int) $request->integer('sort_order'),
        ];
    }
}
