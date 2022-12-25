<?php

namespace OutMart\Exceptions\Baskets;

use Exception;

/**
 * The quote reaches the limit
 */
class QuoteExceedingLimitException extends Exception
{
    public function __construct()
    {
        parent::__construct('You exceed the existing limit and the quantity cannot be decrease');
    }
}
