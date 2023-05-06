<?php

namespace Store\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Product extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'product';
    }

}