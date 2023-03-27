<?php

namespace OutMart;

use Illuminate\Support\ServiceProvider;
use OutMart\Core\ConfigtManager;
use OutMart\Models\Customer;
use OutMart\Models\Order;
use OutMart\Models\Order\Address;
use OutMart\Repositories\BasketRepository;
use OutMart\Repositories\CouponRepository;
use OutMart\Repositories\CustomerRepository;
use OutMart\Repositories\OrderAddressRepository;
use OutMart\Repositories\OrderRepository;
use OutMart\Repositories\ProductRepositorie;
use OutMart\Repositories\QuoteRepository;
use OutMart\Services\BasketService;
use OutMart\Services\CouponService;
use OutMart\Services\CustomerService;
use OutMart\Services\OrderService;

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

        $this->app->singleton('product', function () {
            return new ProductRepositorie();
        });

        $this->app->singleton('basket', function () {
            return new BasketService(
                new BasketRepository,
                new QuoteRepository,
            );
        });

        $this->app->singleton('coupon', function () {
            return new CouponService(
                new CouponRepository
            );
        });

        $this->app->singleton('order', function () {
            return new OrderService(
                new OrderRepository(
                    new Order
                ),
                new OrderAddressRepository(
                    new Address
                )
            );
        });

        $this->app->singleton('customer', function () {
            return new CustomerService(
                new CustomerRepository(
                    new Customer
                )
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
