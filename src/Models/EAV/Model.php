<?php

namespace Store\Models\EAV;

use Store\Base\ModelBase;

class Model extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eav_models';

    public function model()
    {
        return $this->morphTo();
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'model_id', 'id');
    }
}
