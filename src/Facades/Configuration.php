<?php

namespace Store\Facades;

use Illuminate\Support\Facades\Facade;

class Configuration extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'configuration';
    }
}
