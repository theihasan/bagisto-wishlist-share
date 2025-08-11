<?php

namespace Ihasan\BagistoWishlistShare\Tests\Feature;

use Ihasan\BagistoWishlistShare\Models\WishlistShare;
use Ihasan\BagistoWishlistShare\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WishlistShareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_wishlist_share()
    {
        $share = WishlistShare::create([
            'customer_id' => 1,
            'share_token' => 'test-token-123',
            'title' => 'My Test Wishlist',
            'description' => 'Test description',
            'is_public' => true,
            'expires_at' => now()->addDays(30),
        ]);

        $this->assertDatabaseHas('wishlist_shares', [
            'share_token' => 'test-token-123',
            'title' => 'My Test Wishlist',
        ]);

        $this->assertTrue($share->isAccessible());
    }

    /** @test */
    public function it_can_check_if_share_is_expired()
    {
        $expiredShare = WishlistShare::create([
            'customer_id' => 1,
            'share_token' => 'expired-token',
            'title' => 'Expired Wishlist',
            'is_public' => true,
            'expires_at' => now()->subDay(),
        ]);

        $this->assertTrue($expiredShare->isExpired());
        $this->assertFalse($expiredShare->isAccessible());
    }

    /** @test */
    public function it_can_increment_view_count()
    {
        $share = WishlistShare::create([
            'customer_id' => 1,
            'share_token' => 'view-test-token',
            'title' => 'View Test Wishlist',
            'is_public' => true,
            'view_count' => 0,
        ]);

        $share->incrementViewCount();

        $this->assertEquals(1, $share->fresh()->view_count);
    }
}
