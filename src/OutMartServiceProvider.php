<?php

namespace OutMart;

use Illuminate\Support\ServiceProvider;
use OutMart\Manage\Baskets\BasketManager;
use OutMart\Manage\Customers\CustomerManager;

class OutMartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/baskets.php', 'outmart.baskets');

        $this->mergeConfigFrom(__DIR__ . '/../config/customers.php', 'outmart.customers');

        $this->app->singleton('customer', function () {
            return new CustomerManager();
        });

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
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/../publishes/models/Customer.php' => app_path('Models/OutMart/Customer.php'),
            ], ['outmart-customers-model', 'outmart-customers']);
        }
    }
}
