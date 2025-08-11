<?php

namespace Ihasan\BagistoWishlistShare\Database\Seeders;

use Carbon\Carbon;
use Ihasan\BagistoWishlistShare\Models\WishlistShare;
use Ihasan\BagistoWishlistShare\Models\WishlistShareItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Models\Wishlist;
use Webkul\Product\Models\Product;

class WishlistShareSeeder extends Seeder
{
    public function run()
    {
        // Get some existing customers and products
        $customers = Customer::query()->limit(5)->get();
        $products = Product::query()->limit(20)->get();

        if ($customers->isEmpty()) {
            $this->command->info(
                'No customers found. Creating test customers...',
            );
            $this->createTestCustomers();
            $customers = Customer::query()->limit(5)->get();
        }

        if ($products->isEmpty()) {
            $this->command->info(
                'No products found. Please ensure you have products in your database.',
            );

            return;
        }

        $this->command->info('Creating wishlist shares...');

        // Create wishlist shares with different statuses and dates
        $shareData = [
            [
                'title' => 'My Dream Wedding Registry',
                'description' => 'Items for our upcoming wedding celebration',
                'is_public' => true,
                'expires_at' => Carbon::now()->addDays(30),
                'view_count' => 45,
                'shared_platforms' => ['facebook', 'twitter', 'email'],
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Birthday Wishlist 2024',
                'description' => 'Things I would love for my birthday',
                'is_public' => true,
                'expires_at' => Carbon::now()->addDays(60),
                'view_count' => 23,
                'shared_platforms' => ['facebook', 'linkedin'],
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Home Renovation Ideas',
                'description' => 'Products for our home makeover project',
                'is_public' => true,
                'expires_at' => null, // Never expires
                'view_count' => 67,
                'shared_platforms' => ['twitter', 'email', 'copy'],
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'title' => 'Tech Gadgets Collection',
                'description' => 'Latest tech items I am interested in',
                'is_public' => false, // Private
                'expires_at' => Carbon::now()->addDays(45),
                'view_count' => 12,
                'shared_platforms' => ['email'],
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Holiday Gift Ideas',
                'description' => 'Perfect gifts for the holiday season',
                'is_public' => true,
                'expires_at' => Carbon::now()->subDays(10), // Expired
                'view_count' => 89,
                'shared_platforms' => [
                    'facebook',
                    'twitter',
                    'linkedin',
                    'email',
                ],
                'created_at' => Carbon::now()->subDays(45),
            ],
            [
                'title' => 'Fitness Equipment Wishlist',
                'description' => 'Equipment for my home gym setup',
                'is_public' => true,
                'expires_at' => Carbon::now()->addDays(20),
                'view_count' => 34,
                'shared_platforms' => ['facebook', 'copy'],
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'title' => 'Kitchen Essentials',
                'description' => 'Must-have items for cooking enthusiasts',
                'is_public' => true,
                'expires_at' => Carbon::now()->addDays(90),
                'view_count' => 56,
                'shared_platforms' => ['twitter', 'linkedin', 'email'],
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'title' => 'Baby Shower Registry',
                'description' => 'Everything we need for our little one',
                'is_public' => true,
                'expires_at' => Carbon::now()->addDays(15),
                'view_count' => 78,
                'shared_platforms' => ['facebook', 'email'],
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Summer Vacation Essentials',
                'description' => 'Items for our upcoming beach vacation',
                'is_public' => true,
                'expires_at' => Carbon::now()->subDays(5), // Recently expired
                'view_count' => 29,
                'shared_platforms' => ['twitter', 'copy'],
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'title' => 'Art Supplies Collection',
                'description' => 'Professional art supplies for my studio',
                'is_public' => true,
                'expires_at' => null, // Never expires
                'view_count' => 41,
                'shared_platforms' => ['linkedin', 'email'],
                'created_at' => Carbon::now()->subDays(18),
            ],
        ];

        foreach ($shareData as $index => $data) {
            $customer = $customers->random();

            $share = WishlistShare::query()->create([
                'customer_id' => $customer->id,
                'share_token' => Str::random(32),
                'title' => $data['title'],
                'description' => $data['description'],
                'is_public' => $data['is_public'],
                'expires_at' => $data['expires_at'],
                'view_count' => $data['view_count'],
                'shared_platforms' => $data['shared_platforms'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['created_at'],
            ]);

            // Create wishlist items for each share
            $numItems = rand(3, 8);
            $selectedProducts = $products->random($numItems);

            foreach ($selectedProducts as $product) {
                // First, create a wishlist entry if it doesn't exist
                $wishlistItem = Wishlist::query()->firstOrCreate([
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                    'channel_id' => 1, // Default channel
                ]);

                // Then create the share item
                WishlistShareItem::query()->create([
                    'wishlist_share_id' => $share->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price ?? 0,
                    'product_image' => $product->images->first()->path ?? null,
                    'added_at' => $data['created_at']->addMinutes(rand(1, 60)),
                ]);
            }

            $this->command->info(
                "Created share: {$data['title']} with {$numItems} items",
            );
        }

        $this->command->info('Wishlist share test data created successfully!');
        $this->command->info(
            'Total shares created: '.WishlistShare::query()->count(),
        );
        $this->command->info(
            'Total share items created: '.WishlistShareItem::query()->count(),
        );
    }

    private function createTestCustomers(): void
    {
        $customerData = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'password' => bcrypt('password'),
                'is_verified' => 1,
                'channel_id' => 1,
                'customer_group_id' => 1,
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'password' => bcrypt('password'),
                'is_verified' => 1,
                'channel_id' => 1,
                'customer_group_id' => 1,
            ],
            [
                'first_name' => 'Mike',
                'last_name' => 'Johnson',
                'email' => 'mike.johnson@example.com',
                'password' => bcrypt('password'),
                'is_verified' => 1,
                'channel_id' => 1,
                'customer_group_id' => 1,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Wilson',
                'email' => 'sarah.wilson@example.com',
                'password' => bcrypt('password'),
                'is_verified' => 1,
                'channel_id' => 1,
                'customer_group_id' => 1,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'email' => 'david.brown@example.com',
                'password' => bcrypt('password'),
                'is_verified' => 1,
                'channel_id' => 1,
                'customer_group_id' => 1,
            ],
        ];

        foreach ($customerData as $data) {
            Customer::query()->create($data);
        }

        $this->command->info('Created 5 test customers');
    }
}
