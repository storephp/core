<?php

namespace OutMart\Models;

use OutMart\Base\ModelBase;

class Order extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'basket_id',
        'discount_details',
        'sub_total',
        'discount_total',
        'shipping_total',
        'tax_total',
        'grand_total',
    ];
}
