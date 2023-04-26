<?php

namespace Basketin\Support\Exceptions\Coupon;

use Exception;

/**
 * Coupon not found
 */
class CouponNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct('Coupon not found');
    }
}
