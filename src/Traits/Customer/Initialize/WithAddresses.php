<?php

namespace Basketin\Traits\Customer\Initialize;

use Basketin\Models\Customer\Address;

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
