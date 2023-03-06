<?php

namespace OutMart\Models\Store;

use OutMart\Base\ModelBase;

class View extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_views';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'name',
        'slug',
    ];
}
