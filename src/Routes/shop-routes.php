<?php

use Illuminate\Support\Facades\Route;
use Ihasan\BagistoWishlistShare\Http\Controllers\Shop\WishlistShareController;

Route::group(['middleware' => ['web', 'theme', 'locale', 'currency']], function () {
    Route::prefix('customer/account')->group(function () {
        Route::middleware('customer')->group(function () {
            Route::prefix('wishlist')->group(function () {
                Route::post('share/create', [WishlistShareController::class, 'create'])->name('wishlist-share.create');
                Route::get('share/{token}/qr', [WishlistShareController::class, 'generateQR'])->name('wishlist-share.qr');
                Route::delete('share/{token}', [WishlistShareController::class, 'delete'])->name('wishlist-share.delete');
            });
        });
    });

    Route::get('shared-wishlist/{token}', [WishlistShareController::class, 'view'])->name('wishlist-share.view');
});

Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::prefix('wishlist-share')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('create', [WishlistShareController::class, 'apiCreate'])->name('api.wishlist-share.create');
            Route::get('my-shares', [WishlistShareController::class, 'myShares'])->name('api.wishlist-share.my-shares');
        });
        
        Route::get('{token}', [WishlistShareController::class, 'apiView'])->name('api.wishlist-share.view');
    });
});