<?php

namespace OutMart\Models\Basket;

use Exception;
use OutMart\Base\ModelBase;
use OutMart\DataType\ProductSku;
use OutMart\Events\Basket\Quote\QuoteIncrease;
use OutMart\Exceptions\Baskets\QuoteExceedingLimitException;
use OutMart\Exceptions\Baskets\QuoteTheMaxException;

class Quote extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'basket_quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_sku',
        'quantity',
    ];

    /**
     * Return the product relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function basket()
    {
        return $this->hasOne(basket::class, 'id', 'basket_id');
    }

    /**
     * Return the product relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(config('outmart.baskets.product_relation.model'), config('outmart.baskets.product_relation.foreign_key'), 'product_sku');
    }
}
