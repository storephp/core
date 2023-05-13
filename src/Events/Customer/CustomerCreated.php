<?php

namespace Basketin\Events\Customer;

use Illuminate\Foundation\Events\Dispatchable;
use Basketin\Models\Customer;

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
