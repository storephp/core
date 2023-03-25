<?php

namespace OutMart;

use Illuminate\Support\ServiceProvider;
use OutMart\Core\ConfigtManager;
use OutMart\Repositories\CouponRepository;
use OutMart\Repositories\ProductRepositorie;
use OutMart\Services\CouponService;

class OutMartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/outmart.php', 'outmart');

        $this->app->singleton('configuration', function () {
            return new ConfigtManager();
        });

        $this->app->singleton('product', function() {
            return new ProductRepositorie();
        });

        $this->app->singleton('coupon', function() {
            return new CouponService(
                new CouponRepository
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/../config/outmart.php' => config_path('outmart.php'),
            ], ['outmart', 'outmart-config']);
        }
    }
}
