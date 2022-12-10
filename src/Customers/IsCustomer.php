<?php

namespace OutMart\Laravel\Customers;

use OutMart\Laravel\Customers\Models\Customer;

trait IsCustomer
{
    public function customers()
    {
        return $this->morphMany(config('outmart.customers.model', Customer::class), 'customerable');
    }

    public function customer()
    {
        return $this->morphOne(config('outmart.customers.model', Customer::class), 'customerable');
    }

    public function signCustomer(array $metadata = null)
    {
        $customer = $this->customer()->where(function ($query) use ($metadata) {
            foreach ($metadata as $key => $value) {
                $query->whereJsonContains('metadata->' . $key, $value);
            }
        })->first();

        if (!$customer) {
            return $this->customer()->create([
                'metadata' => $metadata,
            ]);
        }

        return $customer;
    }
}
