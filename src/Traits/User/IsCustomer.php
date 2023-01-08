<?php

namespace OutMart\Traits\User;

use OutMart\Models\Customer;

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
            if ($metadata) {
                foreach ($metadata as $key => $value) {
                    $query->whereJsonContains('metadata->' . $key, $value);
                }
            }
        })->first();

        if (!$customer) {
            return $this->customer()->create([
                'first_name' => $this->splitName($this->name)[0],
                'last_name' => $this->splitName($this->name)[1],
                'email' => $this->email,
                'metadata' => $metadata,
            ]);
        }

        return $customer;
    }

    private function splitName($name)
    {
        $name = trim($name);
        return explode(' ', $name);
    }
}
