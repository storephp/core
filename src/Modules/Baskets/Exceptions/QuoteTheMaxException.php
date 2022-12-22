<?php

namespace Bidaea\OutMart\Modules\Baskets\Exceptions;

use Exception;

/**
 * The quote reaches the limit
 */
class QuoteTheMaxException extends Exception
{
    public function __construct()
    {
        parent::__construct('The quote reaches the limit');
    }
}
