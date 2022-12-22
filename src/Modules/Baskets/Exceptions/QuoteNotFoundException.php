<?php

namespace Bidaea\OutMart\Modules\Baskets\Exceptions;

use Exception;

/**
 * This quote is not found
 */
class QuoteNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('This quote is not found');
    }
}
