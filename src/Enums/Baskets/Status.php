<?php

namespace OutMart\Enums\Baskets;

use Exception;

enum Status: int
{
    case OPENED = 1;
    case ABANDONED = 2;
    case ORDERED = 3;

    public static function __callStatic($name, $args)
    {
        $cases = static::cases();

        // Check has statuses
        if ($statuses = config('outmart.baskets.statuses')) {
            // Make custom cases
            $customCases = array_change_key_case(
                array_unique($statuses),
                CASE_UPPER
            );

            // Append to custom cases
            $appendToCustomCases = [];
            foreach ($customCases as $key => $value) {
                if (!in_array($key, array_column($cases, "name"))) {
                    $appendToCustomCases[] = (object) [
                        'name' => $key,
                        'value' => $value,
                    ];
                }
            }

            // Merge cases
            $cases = array_merge($cases, $appendToCustomCases);
        }

        foreach ($cases as $case) {
            if ($case->name === strtoupper($name)) {
                return $case->value;
            }
        }

        throw new Exception('This status does not exist');
    }
}
