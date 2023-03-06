<?php

namespace OutMart\Models\Product;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use OutMart\Base\ModelBase;

class Entry extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_product_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_view_id',
        'product_id',
        'entry_key',
        'entry_value',
    ];

    protected $casts = [
        'entry_value' => 'json',
    ];
}
