<?php

namespace OutMart\Laravel\Customers;

trait HasCustomer
{
    public function customer()
    {
        return $this->morphOne(config('outmart.customers.model'), 'customerable');
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
