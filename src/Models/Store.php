<?php

namespace Store\Models;

use Store\Base\ModelBase;
use Store\Models\Store\View;

class Store extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function views()
    {
        return $this->hasMany(View::class, 'store_id', 'id');
    }
}
