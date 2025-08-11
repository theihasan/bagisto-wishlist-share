<?php

namespace Ihasan\BagistoWishlistShare\Tests\Unit;

use Ihasan\BagistoWishlistShare\Tests\TestCase;

class ConfigTest extends TestCase
{
    /** @test */
    public function it_loads_package_configuration()
    {
        $this->assertTrue(config('wishlist-share.enabled'));
        $this->assertIsArray(config('wishlist-share.social_platforms'));
        $this->assertArrayHasKey('facebook', config('wishlist-share.social_platforms'));
        $this->assertArrayHasKey('twitter', config('wishlist-share.social_platforms'));
        $this->assertArrayHasKey('linkedin', config('wishlist-share.social_platforms'));
        $this->assertArrayHasKey('email', config('wishlist-share.social_platforms'));
    }

    /** @test */
    public function it_has_qr_code_configuration()
    {
        $qrConfig = config('wishlist-share.qr_code');

        $this->assertIsArray($qrConfig);
        $this->assertTrue($qrConfig['enabled']);
        $this->assertEquals(200, $qrConfig['size']);
        $this->assertEquals(10, $qrConfig['margin']);
    }

    /** @test */
    public function it_has_share_token_configuration()
    {
        $tokenConfig = config('wishlist-share.share_token');

        $this->assertIsArray($tokenConfig);
        $this->assertEquals(32, $tokenConfig['length']);
        $this->assertEquals(30, $tokenConfig['expires_in_days']);
    }
}
