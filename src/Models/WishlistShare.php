<?php

namespace Ihasan\BagistoWishlistShare\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\Customer\Models\CustomerProxy;
use Ihasan\BagistoWishlistShare\Contracts\WishlistShare as WishlistShareContract;

class WishlistShare extends Model implements WishlistShareContract
{
    protected $fillable = [
        'customer_id',
        'share_token',
        'title',
        'description',
        'is_public',
        'expires_at',
        'view_count',
        'shared_platforms',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'expires_at' => 'datetime',
        'shared_platforms' => 'array',
    ];

    /**
     * Get the customer that owns the wishlist share.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(CustomerProxy::modelClass());
    }

    /**
     * Get the items for the wishlist share.
     */
    public function items(): HasMany
    {
        return $this->hasMany(WishlistShareItem::class);
    }

    /**
     * Check if the share is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the share is accessible.
     */
    public function isAccessible(): bool
    {
        return $this->is_public && !$this->isExpired();
    }

    /**
     * Increment the view count.
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }
}