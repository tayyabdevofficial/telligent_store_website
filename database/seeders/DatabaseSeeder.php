<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\ServicePackage;
use App\Models\SocialPlatform;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@telligentstore.com'],
            [
                'name' => 'Platform Admin',
                'password' => Hash::make('Password@123'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@telligentstore.com'],
            [
                'name' => 'Sample Customer',
                'password' => Hash::make('Password@123'),
                'role' => UserRole::User,
                'email_verified_at' => now(),
            ],
        );

        $platforms = collect([
            [
                'name' => 'Facebook',
                'slug' => 'facebook',
                'icon' => 'F',
                'accent_color' => '#1877f2',
                'description' => 'Promotion, page monetization, views, comments, and audience growth for Facebook pages and videos.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Instagram',
                'slug' => 'instagram',
                'icon' => 'I',
                'accent_color' => '#e1306c',
                'description' => 'Campaigns for reels, profile growth, comments, engagement packages, and creator monetization support.',
                'sort_order' => 2,
            ],
            [
                'name' => 'YouTube',
                'slug' => 'youtube',
                'icon' => 'Y',
                'accent_color' => '#ff0033',
                'description' => 'Subscriber growth, watch-hour support, views, comments, and monetization-focused campaign packages.',
                'sort_order' => 3,
            ],
            [
                'name' => 'TikTok',
                'slug' => 'tiktok',
                'icon' => 'T',
                'accent_color' => '#111111',
                'description' => 'Short-form campaign boosts for followers, likes, comments, shares, and creator visibility.',
                'sort_order' => 4,
            ],
        ])->map(fn (array $platform) => SocialPlatform::query()->updateOrCreate(
            ['slug' => $platform['slug']],
            $platform + ['is_active' => true],
        ));

        $packages = [
            [
                'platform' => 'facebook',
                'name' => 'Package 1',
                'slug' => '5',
                'service_type' => 'Monetization',
                'description' => 'Starter Facebook monetization support package for basic campaign setup and audience-signal improvement on one eligible page.',
                'delivery_timeline' => 'Review starts within 24 hours and campaign work completes within 3 to 5 business days.',
                'price' => 5.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'platform' => 'facebook',
                'name' => 'Package 2',
                'slug' => '10',
                'service_type' => 'Views',
                'description' => 'Facebook views package for a single approved video or post, intended to increase view-count visibility during the selected campaign window.',
                'delivery_timeline' => 'Delivery typically starts within 24 hours and completes within 2 to 4 business days.',
                'price' => 10.00,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'platform' => 'instagram',
                'name' => 'Package 3',
                'slug' => '15',
                'service_type' => 'Promotion',
                'description' => 'Instagram promotion package for one reel or post, designed to improve reach and initial engagement momentum.',
                'delivery_timeline' => 'Promotion setup begins within 24 hours and completes within 3 to 5 business days.',
                'price' => 15.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
            ],
            [
                'platform' => 'instagram',
                'name' => 'Package 4',
                'slug' => '20',
                'service_type' => 'Promotion',
                'description' => 'Extended Instagram promotion package for a single campaign asset with broader reach support and engagement lift.',
                'delivery_timeline' => 'Promotion setup begins within 24 hours and completes within 3 to 7 business days.',
                'price' => 20.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
            ],
            [
                'platform' => 'youtube',
                'name' => 'Package 5',
                'slug' => '25',
                'service_type' => 'Subscribers',
                'description' => 'YouTube subscriber-growth package for one channel, focused on audience traction and improved channel visibility.',
                'delivery_timeline' => 'Delivery usually starts within 24 hours and completes within 5 to 7 business days.',
                'price' => 25.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
            ],
            [
                'platform' => 'youtube',
                'name' => 'Package 6',
                'slug' => '30',
                'service_type' => 'Comments',
                'description' => 'YouTube comments package for one published video, designed to improve visible engagement on the selected content.',
                'delivery_timeline' => 'Delivery usually starts within 24 hours and completes within 2 to 5 business days.',
                'price' => 30.00,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 6,
            ],
            [
                'platform' => 'tiktok',
                'name' => 'Package 7',
                'slug' => '35',
                'service_type' => 'Promotion',
                'description' => 'TikTok promotion package for one video to support short-form visibility and campaign momentum.',
                'delivery_timeline' => 'Campaign work usually starts within 24 hours and completes within 2 to 5 business days.',
                'price' => 35.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 7,
            ],
            [
                'platform' => 'tiktok',
                'name' => 'Package 8',
                'slug' => '40',
                'service_type' => 'Views',
                'description' => 'TikTok views package for one approved video, intended to increase view-count exposure during the selected service period.',
                'delivery_timeline' => 'Delivery usually starts within 24 hours and completes within 2 to 4 business days.',
                'price' => 40.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 8,
            ],
            [
                'platform' => 'tiktok',
                'name' => 'Package 9',
                'slug' => '45',
                'service_type' => 'Monetization',
                'description' => 'TikTok monetization support package focused on account-readiness signals and campaign consulting for one creator profile.',
                'delivery_timeline' => 'Review starts within 24 hours and service work completes within 3 to 7 business days.',
                'price' => 45.00,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 9,
            ],
            [
                'platform' => 'tiktok',
                'name' => 'Package 10',
                'slug' => '50',
                'service_type' => 'Monetization',
                'description' => 'Advanced TikTok monetization support package with a broader campaign scope for one eligible creator account.',
                'delivery_timeline' => 'Review starts within 24 hours and service work completes within 5 to 7 business days.',
                'price' => 50.00,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 10,
            ],
        ];

        foreach ($packages as $package) {
            $platform = $platforms->firstWhere('slug', $package['platform']);

            ServicePackage::query()->updateOrCreate(
                ['slug' => $package['slug']],
                [
                    'social_platform_id' => $platform->id,
                    'name' => $package['name'],
                    'slug' => $package['slug'],
                    'service_type' => $package['service_type'],
                    'description' => $package['description'],
                    'delivery_timeline' => $package['delivery_timeline'],
                    'price' => $package['price'],
                    'is_active' => $package['is_active'],
                    'is_featured' => $package['is_featured'] ?? false,
                    'sort_order' => $package['sort_order'] ?? 0,
                ],
            );
        }
    }
}
