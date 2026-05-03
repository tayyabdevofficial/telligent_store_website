<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentLinkController as AdminPaymentLinkController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PlatformController as AdminPlatformController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentLinkController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::get('/terms-conditions', [PageController::class, 'terms'])->name('terms');
Route::get('/checkout/{package:slug}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{package:slug}', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/orders/{order}/{token}/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/orders/{order}/{token}/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::get('/pay', [PaymentLinkController::class, 'custom'])->name('payments.custom.show');
Route::post('/pay', [PaymentLinkController::class, 'storeCustom'])->name('payments.custom.store');
Route::get('/pay/{paymentLink:slug}', [PaymentLinkController::class, 'show'])->name('payments.link.show');
Route::post('/pay/{paymentLink:slug}', [PaymentLinkController::class, 'store'])->name('payments.link.store');
Route::post('/webhooks/stripe', StripeWebhookController::class)->name('webhooks.stripe');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard/recent-orders', [DashboardController::class, 'recentOrders'])->name('dashboard.recent-orders');
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('platforms', AdminPlatformController::class)->except(['show', 'destroy']);
        Route::resource('packages', AdminPackageController::class)->except(['show', 'destroy']);
        Route::resource('payment-links', AdminPaymentLinkController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
        Route::resource('payments', AdminPaymentController::class)->only(['index', 'show']);
        Route::resource('users', AdminUserController::class)->only(['index', 'show']);
    });
});

require __DIR__.'/settings.php';
