<?php

namespace OutMart\Models\Basket;

use Exception;
use OutMart\Base\ModelBase;
use OutMart\DataType\ProductSku;
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

    public static function boot()
    {
        parent::boot();

        static::creating(function (Quote $quote) {
            if (!$quote->product_sku instanceof ProductSku) {
                throw new Exception("You must use `\OutMart\DataType\ProductSku` for add SKU");
            }
        });
    }

    /**
     * Increase quantity
     * 
     * @param int $quantity
     * 
     * @return \OutMart\Models\Quote
     */
    public function increase(int $quantity)
    {
        if ($this->quantity >= config('outmart.baskets.max_quote')) {
            throw new QuoteTheMaxException();
        }

        $this->increment('quantity', $quantity);

        return $this;
    }

    /**
     * Decrease quantity
     * 
     * @param int $quantity
     * 
     * @return \OutMart\Models\Quote
     */
    public function decrease(int $quantity)
    {
        if ($this->quantity < $quantity) {
            throw new QuoteExceedingLimitException();
        }

        $this->decrement('quantity', $quantity);

        return $this;
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
