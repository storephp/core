<?php

namespace Store;

use Store\Console\FillStateStatusOrders;
use Store\Console\SetupBasketin;
use Store\Core\ConfigtManager;
use Store\Models\Order\Address;
use Store\Repositories\OrderAddressRepository;
use Store\Support\Repositories\BasketRepository;
use Store\Support\Repositories\CouponRepository;
use Store\Support\Repositories\CustomerRepository;
use Store\Support\Repositories\OrderRepository;
use Store\Support\Repositories\ProductRepository;
use Store\Support\Repositories\QuoteRepository;
use Store\Support\Services\BasketService;
use Store\Support\Services\CouponService;
use Store\Support\Services\CustomerService;
use Store\Support\Services\OrderService;
use Store\Support\Traits\HasSetupBasketin;
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
        $this->mergeConfigFrom(__DIR__ . '/../config/store.php', 'store');

        $this->app->singleton('configuration', function () {
            return new ConfigtManager();
        });

        $this->app->singleton('product', function () {
            return new ProductRepository();
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
                new OrderRepository,
                new OrderAddressRepository(
                    new Address
                )
            );
        });

        $this->app->singleton('customer', function () {
            return new CustomerService(
                new CustomerRepository
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
                __DIR__ . '/../config/store.php' => config_path('store.php'),
            ], ['store', 'store-config']);

            $this->commands([
                SetupBasketin::class,
            ]);
        }
    }
}
