<?php

namespace Ihasan\BagistoWishlistShare\Contracts;

interface WishlistShare
{
    /**
     * Check if the share is expired.
     */
    public function isExpired(): bool;

    /**
     * Check if the share is accessible.
     */
    public function isAccessible(): bool;

    /**
     * Increment the view count.
     */
    public function incrementViewCount(): void;
}