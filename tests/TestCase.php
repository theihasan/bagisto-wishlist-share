<?php

namespace Ihasan\BagistoWishlistShare\Tests;

use Ihasan\BagistoWishlistShare\Providers\WishlistShareServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../src/Database/Migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            WishlistShareServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('wishlist-share.enabled', true);
    }
}