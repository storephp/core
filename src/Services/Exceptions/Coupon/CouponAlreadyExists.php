<?php

namespace OutMart\Services\Exceptions\Coupon;

use Exception;

/**
 * The quote reaches the limit
 */
class CouponAlreadyExists extends Exception
{
    public function __construct(
        public $message = 'Coupon code already exists',
    ) {
        parent::__construct($this->message);
    }
}
