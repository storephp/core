<?php

namespace Basketin\Support\Exceptions\Coupon;

use Exception;

/**
 * The quote reaches the limit
 */
class CouponNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct('Coupon not found');
    }
}
