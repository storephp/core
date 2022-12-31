<?php

namespace OutMart\Observers;

use OutMart\Events\Customer\CustomerCreated;
use OutMart\Events\Customer\CustomerCreating;
use OutMart\Models\Customer;

class CustomerObserver
{
    /**
     * Handle the Customer "creating" event.
     *
     * @param  \OutMart\Models\Customer $customer
     * @return void
     */
    public function creating(Customer $customer)
    {
        CustomerCreating::dispatch($customer);
    }

    /**
     * Handle the Customer "created" event.
     *
     * @param  \OutMart\Models\Customer $customer
     * @return void
     */
    public function created(Customer $customer)
    {
        CustomerCreated::dispatch($customer);
    }
}
