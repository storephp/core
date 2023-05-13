<?php

namespace Store\Support\Exceptions\Coupon;

use Exception;

/**
 * Coupon code already exists
 */
class CouponAlreadyExists extends Exception
{
    public function __construct()
    {
        parent::__construct('Coupon code already exists');
    }
}
