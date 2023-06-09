<?php

namespace Store\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Customer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'customer';
    }
}
