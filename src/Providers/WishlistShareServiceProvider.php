<?php

namespace Ihasan\BagistoWishlistShare\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class WishlistShareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . "/../Database/Migrations");

        $this->loadRoutesFrom(__DIR__ . "/../Routes/shop-routes.php");
        $this->loadRoutesFrom(__DIR__ . "/../Routes/admin-routes.php");

        $this->loadViewsFrom(__DIR__ . "/../Resources/views", "wishlist-share");

        $this->loadTranslationsFrom(
            __DIR__ . "/../Resources/lang",
            "wishlist-share",
        );

        $this->publishes(
            [
                __DIR__ . "/../Resources/assets" => public_path(
                    "vendor/wishlist-share",
                ),
            ],
            "wishlist-share-assets",
        );

        $this->publishes(
            [
                __DIR__ . "/../Resources/assets/js/wishlist-share-inject.js" => public_path(
                    "wishlist-share-inject.js",
                ),
            ],
            "wishlist-share-inject",
        );

        $this->publishes(
            [
                __DIR__ . "/../Resources/views" => resource_path(
                    "views/vendor/wishlist-share",
                ),
            ],
            "wishlist-share-views",
        );

        $this->publishes(
            [
                __DIR__ . "/../Resources/lang" => resource_path(
                    "lang/vendor/wishlist-share",
                ),
            ],
            "wishlist-share-lang",
        );

        $this->publishes(
            [
                __DIR__ . "/../Config/wishlist-share.php" => config_path(
                    "wishlist-share.php",
                ),
            ],
            "wishlist-share-config",
        );

        $this->registerEventListeners();
        $this->registerViewComposers();
        $this->registerBladeDirectives();
        $this->registerAdminMenu();
        $this->registerACL();
        $this->registerSystemConfig();
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(ModelServiceProvider::class);

        $this->mergeConfigFrom(
            __DIR__ . "/../Config/wishlist-share.php",
            "wishlist-share",
        );
    }

    /**
     * Register event listeners.
     */
    protected function registerEventListeners(): void
    {
        // Use view composer to inject share functionality
        View::composer("shop::customers.account.wishlist.index", function (
            $view,
        ) {
            $view->with([
                "shareModal" => view(
                    "wishlist-share::customer.share-modal",
                )->render(),
                "wishlistShareAssets" => true,
            ]);
        });
    }

    /**
     * Register view composers.
     */
    protected function registerViewComposers(): void
    {
        View::composer("shop::customers.account.wishlist.index", function (
            $view,
        ) {
            $view->with("shareEnabled", true);
        });

        // Register the wishlist share component
        Blade::component('wishlist-share-integration', 
            \Illuminate\View\Component::class
        );
    }

    /**
     * Register Blade directives.
     */
    protected function registerBladeDirectives(): void
    {
        Blade::directive("wishlistShare", function () {
            return "<?php echo view('wishlist-share::customer.share-modal')->render(); ?>";
        });

        Blade::directive("wishlistShareAssets", function () {
            return "@bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'], 'wishlist-share')";
        });
    }

    /**
     * Register admin menu items.
     */
    protected function registerAdminMenu(): void
    {
        $this->mergeConfigFrom(__DIR__ . "/../Config/menu.php", "menu.admin");
    }

    /**
     * Register ACL permissions.
     */
    protected function registerACL(): void
    {
        $this->mergeConfigFrom(__DIR__ . "/../Config/acl.php", "acl");
    }

    /**
     * Register system configuration.
     */
    protected function registerSystemConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . "/../Config/system.php", "core.configuration");
    }
}