<?php

namespace Ihasan\BagistoWishlistShare\Providers;

use Ihasan\BagistoWishlistShare\Events\WishlistShared;
use Ihasan\BagistoWishlistShare\Listeners\LogWishlistShare;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
