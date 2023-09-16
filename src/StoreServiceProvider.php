<?php

namespace Store;

use Illuminate\Support\ServiceProvider;
use Store\Console\FillStateStatusOrders;
use Store\Console\SetupStore;
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
use Store\Support\Services\ProductService;
use Store\Support\Traits\HasSetupStore;

class StoreServiceProvider extends ServiceProvider
{
    use HasSetupStore;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        config([
            'auth.guards.customer' => array_merge([
                'driver' => 'session',
                'provider' => 'customer',
            ], config('auth.guards.customer', [])),
        ]);

        config([
            'auth.providers.customer' => array_merge([
                'driver' => 'eloquent',
                'model' => \Store\Models\Customer::class,
            ], config('auth.providers.customer', [])),
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../config/store.php', 'store');

        $this->app->singleton('configuration', function () {
            return new ConfigtManager();
        });

        $this->app->singleton('product', function () {
            return new ProductService(
                new ProductRepository
            );
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

            if (config('store.setup.auto_migration', true)) {
                $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            }

            $this->publishes([
                __DIR__ . '/../config/store.php' => config_path('store.php'),
            ], ['store', 'store-config']);

            $this->commands([
                SetupStore::class,
            ]);
        }
    }
}
