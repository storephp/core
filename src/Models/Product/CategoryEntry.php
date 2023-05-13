<?php

namespace Basketin\Models\Product;

use Basketin\Base\ModelBase;

class CategoryEntry extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_category_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_view_id',
        'category_id',
        'entry_key',
        'entry_value',
    ];
}
