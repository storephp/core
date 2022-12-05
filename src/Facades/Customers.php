<?php

namespace OutMart\Laravel\Customers\Facades;

use Illuminate\Support\Facades\Facade;

class Customers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'customers';
    }
}
