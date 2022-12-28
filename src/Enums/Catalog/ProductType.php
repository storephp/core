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

        if ($case = array_filter(static::cases(), fn ($item) => $item->name == $name)) {
            return current($case)->value;
        }

        throw new Exception('This product type does not exists');
    }
}
