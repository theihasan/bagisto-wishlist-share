<?php

namespace Ihasan\BagistoWishlistShare\Events;

use Ihasan\BagistoWishlistShare\Models\WishlistShare;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WishlistShared
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public WishlistShare $wishlistShare
    ) {}
}
