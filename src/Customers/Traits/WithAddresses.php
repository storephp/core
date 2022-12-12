<?php

namespace Bidaea\OutMart\Customers\Traits;

use Bidaea\OutMart\Customers\Models\Address;

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
