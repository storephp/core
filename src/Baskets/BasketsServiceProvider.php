<?php

namespace OutMart\Laravel\Baskets;

use Illuminate\Support\ServiceProvider;
use OutMart\Laravel\Baskets\Manage\BasketManager;

class BasketsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/baskets.php', 'outmart.baskets');

        $this->app->singleton('basket', function () {
            return new BasketManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
