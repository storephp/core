<?php

namespace Basketin\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Order extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'order';
    }
}
