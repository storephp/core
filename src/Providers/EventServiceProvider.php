<?php

namespace Store\Providers;

use Store\Models\Basket;
use Store\Models\Customer;
class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \Store\Events\Basket\BasketUpdating::class => [
            \Store\Listeners\Basket\CheckStatusUpdate::class,
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
        if ($observerCustomer = config('store.customers.observers')) {
            $customer = config('store.customers.model', Customer::class);
            $customer::observe($observerCustomer);
        }

        // Customer observer
        if ($observerBasket = config('store.baskets.observers')) {
            Basket::observe($observerBasket);
        }
    }
}
