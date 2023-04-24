<?php

namespace Basketin;

use Basketin\Console\FillStateStatusOrders;
use Basketin\Console\SetupBasketin;
use Basketin\Core\ConfigtManager;
use Basketin\Models\Customer;
use Basketin\Models\Order;
use Basketin\Models\Order\Address;
use Basketin\Repositories\CouponRepository;
use Basketin\Repositories\CustomerRepository;
use Basketin\Repositories\OrderAddressRepository;
use Basketin\Repositories\OrderRepository;
use Basketin\Repositories\ProductRepositorie;
use Basketin\Services\CouponService;
use Basketin\Services\CustomerService;
use Basketin\Services\OrderService;
use Basketin\Support\Repositories\BasketRepository;
use Basketin\Support\Repositories\QuoteRepository;
use Basketin\Support\Services\BasketService;
use Basketin\Support\Traits\HasSetupBasketin;
use Illuminate\Support\ServiceProvider;

class BasketinServiceProvider extends ServiceProvider
{
    use HasSetupBasketin;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/basketin.php', 'basketin');

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

            $this->appendCommandToSetup(FillStateStatusOrders::class);

            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/../config/basketin.php' => config_path('basketin.php'),
            ], ['basketin', 'basketin-config']);

            $this->commands([
                SetupBasketin::class,
            ]);
        }
    }
}
