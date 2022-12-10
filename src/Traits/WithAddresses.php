<?php

namespace OutMart\Laravel\Customers\Traits;

use OutMart\Laravel\Customers\Models\Address;

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
