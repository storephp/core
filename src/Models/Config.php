<?php

namespace Basketin\Models;

use Basketin\Base\ModelBase;

class Config extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'core_configs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_view_id',
        'path',
        'value',
    ];
}
