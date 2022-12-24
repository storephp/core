<?php

namespace Bidaea\OutMart\Facades\Catalog;

use Illuminate\Support\Facades\Facade;

class Category extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'category';
    }
}
