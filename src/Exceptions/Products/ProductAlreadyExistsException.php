<?php

namespace Store\Exceptions\Products;

use Exception;

/**
 * The product already exists
 */
class ProductAlreadyExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct('This product already exists');
    }
}
