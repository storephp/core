<?php

namespace OutMart\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Customer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'customer';
    }
}