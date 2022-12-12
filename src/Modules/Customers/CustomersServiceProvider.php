<?php

namespace Bidaea\OutMart\Modules\Customers;

use Illuminate\Support\ServiceProvider;

class CustomersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/customers.php', 'outmart.customers');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (config('outmart.customers.migrations', false)) {
                $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
            }

            $this->publishes([
                __DIR__ . '/database/migrations/' => database_path('migrations/outmart'),
            ], ['outmart-customers-migrations', 'outmart-customers']);

            $this->publishes([
                __DIR__ . '/config/customers.php' => config_path('outmart/customers.php'),
            ], ['outmart-customers-config', 'outmart-customers']);

            $this->publishes([
                __DIR__ . '/publishes/models/Customer.php' => app_path('Models/OutMart/Customer.php'),
            ], ['outmart-customers-model', 'outmart-customers']);
        }
    }
}
