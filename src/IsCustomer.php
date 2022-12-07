<?php

namespace OutMart\Laravel\Customers;

use App\Models\OutMart\Customer;

trait IsCustomer
{
    public function customers()
    {
        return $this->{config('outmart.customers.multiple', true) ? 'morphMany' : 'morphOne'}(config('outmart.customers.model', Customer::class), 'customerable');
    }

    public function customer()
    {
        return $this->morphOne(config('outmart.customers.model', Customer::class), 'customerable');
    }

    public function signCustomer(array $metadata = null)
    {
        return $this->customers()->firstOrCreate([
            'metadata' => $metadata
        ]);
    }
}
