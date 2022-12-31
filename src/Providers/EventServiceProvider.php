<?php

namespace OutMart\Providers;

use OutMart\Models\Customer;
use OutMart\Observers\CustomerObserver;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
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
 