<?php

namespace Bidaea\OutMart\Modules\Baskets\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outmart_basket_quotes';

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
    public function product()
    {
        return $this->hasOne(config('outmart.baskets.product_relation.model'), config('outmart.baskets.product_relation.foreign_key'), 'product_sku');
    }
}
