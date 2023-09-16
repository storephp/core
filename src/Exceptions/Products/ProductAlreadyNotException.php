<?php

namespace Store\Exceptions\Products;

use Exception;

/**
 * The product not exists
 */
class ProductAlreadyNotException extends Exception
{
    public function __construct()
    {
        parent::__construct('This product not exists');
    }
}
