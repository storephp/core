<?php

namespace Basketin\Models\EAV;

use Basketin\Base\ModelBase;

class Attribute extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eav_attributes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model_id',
        'entity_id',
    ];

    public function model()
    {
        return $this->morphTo();
    }

    public function entity()
    {
        return $this->hasOne(Entity::class, 'id', 'entity_id');
    }

    public function value()
    {
        return $this->hasOne(Value::class, 'attribute_id', 'id');
    }
}
