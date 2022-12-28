<?php

namespace OutMart\Enums\Baskets;

use Exception;

/**
 * This statuses list for baskets
 * 
 * You can add more statuses from config file at path `config/outmart/baskets.php`
 * 
 * 'statuses' => [
 *    'DONE' => 7,
 * ],
 * 
 * And you can overwrite on exists case from `statuses` array.
 */
enum Status: int
{
    case OPENED = 1;
    case ABANDONED = 2;
    case ORDERED = 3;

    public static function __callStatic($name, $args)
    {
        $name = strtoupper($name);

        if ($statuses = config('outmart.baskets.statuses')) {
            // DETECT DUPLICATE STATUSES ON CONFIG
            $detectDuplicate = array_count_values($statuses);
            $detectDuplicate = array_walk($detectDuplicate, function ($key, $value) {
                if ($key != 1) {
                    throw new Exception('Duplicate value ' . $value);
                }
            });

            // SEARCH IN CONFIG
            if ($status = array_change_key_case($statuses, CASE_UPPER)[$name] ?? false) {
                return $status;
            }
        }

        // CHECK CASE EXISTS
        if ($case = array_filter(static::cases(), fn ($item) => $item->name == $name)) {
            return current($case)->value;
        }

        throw new Exception('This status does not exists');
    }
}
