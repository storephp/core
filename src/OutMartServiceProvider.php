<?php

namespace OutMart;

use Illuminate\Support\ServiceProvider;

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

        $this->mergeConfigFrom(__DIR__ . '/../config/baskets.php', 'outmart.baskets');

        $this->mergeConfigFrom(__DIR__ . '/../config/customers.php', 'outmart.customers');
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
        }
    }
}
