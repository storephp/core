<?php

namespace OutMart\Laravel\Customers;

use OutMart\Laravel\Customers\Models\Customer;

class CustomersManager
{
    public function get()
    {
        $customers = Customer::with(['customerable'])->get();

        return $customers;
    }
}
