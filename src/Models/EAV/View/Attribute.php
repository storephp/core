<?php

namespace Store\Models\EAV\View;

use Store\Base\ModelBase;

class Attribute extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'view_eav_attributes';

    protected $casts = [
        'attribute_value' => 'json',
    ];

    public function model()
    {
        return $this->morphTo();
    }
}
