<?php

namespace Ihasan\BagistoWishlistShare\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Ihasan\BagistoWishlistShare\Events\WishlistShared;
use Ihasan\BagistoWishlistShare\Listeners\LogWishlistShare;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        WishlistShared::class => [
            LogWishlistShare::class,
        ],
    ];
}