<?php

namespace OutMart\Providers;

use OutMart\Models\Customer;
use OutMart\Observers\CustomerObserver;

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
        $customer = config('outmart.customers.model', Customer::class);
        $customer::observe([CustomerObserver::class]);
    }
}
