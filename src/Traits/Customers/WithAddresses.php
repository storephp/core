<?php

namespace OutMart\Traits\Customers;

use OutMart\Customers\Models\Address;

trait WithAddresses
{
    public function initializeWithAddresses()
    {
        $this->with[] = 'addresses';
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
