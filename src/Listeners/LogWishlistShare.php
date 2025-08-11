<?php

namespace Ihasan\BagistoWishlistShare\Listeners;

use Ihasan\BagistoWishlistShare\Events\WishlistShared;
use Illuminate\Support\Facades\Log;

class LogWishlistShare
{
    public function handle(WishlistShared $event): void
    {
        Log::info('Wishlist shared', [
            'customer_id' => $event->wishlistShare->customer_id,
            'share_token' => $event->wishlistShare->share_token,
            'title' => $event->wishlistShare->title,
            'items_count' => $event->wishlistShare->items->count(),
        ]);
    }
}
