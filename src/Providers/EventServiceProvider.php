<?php

namespace OutMart\Providers;

use OutMart\Models\Basket;
use OutMart\Models\Customer;
class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \OutMart\Events\Basket\BasketUpdating::class => [
            \OutMart\Listeners\Basket\CheckStatusUpdate::class,
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
        if ($observerCustomer = config('outmart.customers.observers')) {
            $customer = config('outmart.customers.model', Customer::class);
            $customer::observe($observerCustomer);
        }

        // Customer observer
        if ($observerBasket = config('outmart.baskets.observers')) {
            Basket::observe($observerBasket);
        }
    }
}
