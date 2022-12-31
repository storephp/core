<?php

namespace OutMart\Events\Customer;

use Illuminate\Foundation\Events\Dispatchable;
use OutMart\Models\Customer;

class CustomerCreating
{
    use Dispatchable;

    public $customer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}
