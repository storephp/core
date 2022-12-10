<?php

namespace OutMart\Laravel\Baskets\Facades;

use Illuminate\Support\Facades\Facade;

class Basket extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'basket';
    }
}
