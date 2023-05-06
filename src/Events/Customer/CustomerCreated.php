<?php

namespace Store\Events\Customer;

use Illuminate\Foundation\Events\Dispatchable;
use Store\Models\Customer;

class CustomerCreated
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
