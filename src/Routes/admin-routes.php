<?php

use Illuminate\Support\Facades\Route;
use Ihasan\BagistoWishlistShare\Http\Controllers\Admin\WishlistShareController;
use Ihasan\BagistoWishlistShare\Http\Controllers\Admin\DashboardController;
use Ihasan\BagistoWishlistShare\Http\Controllers\Admin\SettingsController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::prefix('wishlist-share')->name('admin.wishlist-share.')->group(function () {
        // Analytics Dashboard
        Route::get('analytics', [WishlistShareController::class, 'index'])->name('analytics.index');
        Route::get('analytics/data', [WishlistShareController::class, 'analytics'])->name('analytics.data');
        Route::get('analytics/export', [WishlistShareController::class, 'export'])->name('analytics.export');
        
        // Shares Management
        Route::get('shares', [WishlistShareController::class, 'shares'])->name('shares.index');
        Route::get('shares/{id}', [WishlistShareController::class, 'show'])->name('shares.show');
        Route::delete('shares/{id}', [WishlistShareController::class, 'destroy'])->name('shares.destroy');
        Route::post('shares/bulk-destroy', [WishlistShareController::class, 'bulkDestroy'])->name('shares.bulk-destroy');
        
        // Maintenance
        Route::post('cleanup-expired', [WishlistShareController::class, 'cleanupExpired'])->name('cleanup-expired');
        
        // Dashboard Widget
        Route::get('dashboard/widget', [DashboardController::class, 'widget'])->name('dashboard.widget');
        
        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');
    });
});