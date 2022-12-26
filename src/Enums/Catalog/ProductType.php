<?php

namespace OutMart\Enums\Catalog;

use Exception;

enum ProductType: int
{
    case CONFIGURABLE = 1;
    case SIMPLE = 2;

    public static function __callStatic($name, $args)
    {
        $name = strtoupper($name);

        // CHECK CASE EXISTS
        if ($exists = array_filter(static::cases(), fn ($item) => $item->name == $name)) {
            return $exists[0]->value;
        }

        throw new Exception('This product type does not exists');
    }
}
