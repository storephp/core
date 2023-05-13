<?php

namespace Store\Models\EAV;

use Store\Base\ModelBase;

class Entity extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eav_entities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model_type',
        'entity_key',
    ];

    public function attribute()
    {
        return $this->hasOne(Attribute::class, 'entity_id', 'id');
    }
}
