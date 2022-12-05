<?php

namespace OutMart\Laravel\Customers;

use OutMart\Laravel\Customers\Models\Customer;

trait HasCustomer
{
    public function customer()
    {
        return $this->morphOne(Customer::class, 'customerable');
    }

    public function createCustomer(array $metadata = null)
    {
        $customer = $this->customer()->where(function ($query) use ($metadata) {
            foreach ($metadata as $key => $value) {
                $query->whereJsonContains('metadata->' . $key, $value);
            }
        })->first();

        if (!$customer) {
            $this->customer()->create([
                'metadata' => $metadata,
            ]);

            return true;
        }

        return false;
    }
}
