<?php

namespace Bidaea\OutMart\Modules\Customers\Traits;

use Bidaea\OutMart\Modules\Customers\Models\Address;

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
