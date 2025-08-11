<?php

namespace Ihasan\BagistoWishlistShare\Tests;

use Ihasan\BagistoWishlistShare\Providers\WishlistShareServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create customers table for foreign key constraint
        $this->createCustomersTable();

        $this->loadMigrationsFrom(__DIR__.'/../src/Database/Migrations');
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

    protected function createCustomersTable()
    {
        $this->app['db']->connection()->getSchemaBuilder()->create('customers', function ($table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
