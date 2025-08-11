<?php

namespace Ihasan\BagistoWishlistShare\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Product\Models\ProductProxy;
use Ihasan\BagistoWishlistShare\Contracts\WishlistShareItem as WishlistShareItemContract;

class WishlistShareItem extends Model implements WishlistShareItemContract
{
    protected $fillable = [
        'wishlist_share_id',
        'product_id',
        'product_options',
        'quantity',
    ];

    protected $casts = [
        'product_options' => 'array',
    ];

    /**
     * Get the wishlist share that owns the item.
     */
    public function wishlistShare(): BelongsTo
    {
        return $this->belongsTo(WishlistShare::class);
    }

    /**
     * Get the product for the item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }
}