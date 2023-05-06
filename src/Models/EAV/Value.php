<?php

namespace Store\Models\EAV;

use Store\Base\ModelBase;

class Value extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eav_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_view_id',
        'attribute_id',
        'attribute_value'
    ];

    protected $casts = [
        'attribute_value' => 'json',
    ];
}
