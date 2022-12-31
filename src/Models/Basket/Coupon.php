<?php

namespace OutMart\Models\Basket;

use OutMart\Base\ModelBase;

class Coupon extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'basket_coupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'discount_value',
    ];
}
