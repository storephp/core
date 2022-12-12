<?php

namespace Bidaea\OutMart;

use Bidaea\OutMart\Modules\Baskets\Manage\BasketManager;
use Bidaea\OutMart\Modules\Customers\Manage\CustomerManager;
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
        // 
    }
}
