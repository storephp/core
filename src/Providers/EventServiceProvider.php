<?php

namespace Basketin\Providers;

use Basketin\Models\Basket;
use Basketin\Models\Customer;
class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \Basketin\Events\Basket\BasketUpdating::class => [
            \Basketin\Listeners\Basket\CheckStatusUpdate::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        // Customer observer
        if ($observerCustomer = config('basketin.customers.observers')) {
            $customer = config('basketin.customers.model', Customer::class);
            $customer::observe($observerCustomer);
        }

        // Customer observer
        if ($observerBasket = config('basketin.baskets.observers')) {
            Basket::observe($observerBasket);
        }
    }
}
