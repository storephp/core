<?php

namespace Store\Models\Basket;

use Exception;
use Store\Base\ModelBase;
use Store\DataType\ProductSku;
use Store\Events\Basket\Quote\QuoteIncrease;
use Store\Exceptions\Baskets\QuoteExceedingLimitException;
use Store\Exceptions\Baskets\QuoteTheMaxException;

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
        return $this->hasOne(config('store.baskets.product_relation.model'), config('store.baskets.product_relation.foreign_key'), 'product_sku');
    }
}
