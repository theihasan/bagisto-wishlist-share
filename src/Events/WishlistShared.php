<?php

namespace Ihasan\BagistoWishlistShare\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Ihasan\BagistoWishlistShare\Models\WishlistShare;

class WishlistShared
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WishlistShare $wishlistShare
    ) {}
}