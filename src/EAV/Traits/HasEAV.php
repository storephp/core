<?php

namespace Store\EAV\Traits;

use Illuminate\Database\Eloquent\Builder;
use Store\EAV\Contracts\MultipleStoreViews;
use Store\Models\EAV\Entity;
use Store\Models\EAV\Model;

trait HasEAV
{
    /**
     * Get Callbacks
     */
    protected $_getAttributes = [];

    /**
     * Set Callbacks
     */
    protected $_setAttributes = [];

    /**
     * Out Attributes
     */
    protected $outAttributes = [];

    public function initializeHasEAV()
    {
        $fillableEntities = (method_exists($this, 'fillableEntities')) ? $this->fillableEntities() : $this->fillableEntities;

        foreach ($fillableEntities as $key) {
            $this->addGetterAttribute($key, 'getEntities');
            $this->addSetterAttribute($key, 'setEntities');
        }
    }

    public function addGetterAttribute($key, $callback)
    {
        $this->_getAttributes[$key] = $callback;
    }

    public function addSetterAttribute($key, $callback)
    {
        $this->_setAttributes[$key] = $callback;
    }

    /**
     * Get Attribute
     */
    public function getEntities($key)
    {
        if (!$this->outAttributes) {
            $model = $this->eavModel()->with([
                'attributes.entity',
                'attributes.values' => function ($q) {
                    if ($this instanceof MultipleStoreViews) {
                        $q->where('store_view_id', '=', $this->getStoreViewId())
                            ->orWhereNull('store_view_id')
                            ->orderBy('store_view_id', 'DESC');
                    } else {
                        $q->whereNull('store_view_id');
                    }
                },
            ])->first()?->toArray();

            $outAttributes = [];

            if (!empty($model['attributes'])) {
                foreach ($model['attributes'] as $attribute) {
                    $outAttributes[$attribute['entity']['entity_key']] = $attribute['values'][0]['attribute_value'] ?? null;
                }
            }

            $this->outAttributes = $outAttributes;
        }

        return $this->outAttributes[$key] ?? null;
    }

    /**
     * Set Attribute
     */
    public function setEntities($key, $value)
    {
        if (is_null($value)) {
            return;
        }

        if (!$entity = Entity::where('model_type', get_class())->where('entity_key', $key)->first()) {
            $entity = Entity::create([
                'model_type' => get_class(),
                'entity_key' => $key,
            ]);
        }

        if (!$model = $this->eavModel()->where([
            'model_type' => get_class(),
            'model_id' => $this->id,
        ])->first()) {
            $model = $this->eavModel()->create();
        }

        if (!$attribute = $model->attributes()->where('entity_id', $entity->id)->first()) {
            $attribute = $model->attributes()->create([
                'entity_id' => $entity->id,
            ]);
        }

        if (
            !$_value = $attribute->value()
            ->whereNull('store_view_id')
            ->where('attribute_id', $attribute->id)
            ->where('attribute_value', $value)
            ->first()
        ) {
            $_value = $attribute->value()
                ->where('attribute_id', $attribute->id)
                ->where('store_view_id', '=', $this->getStoreViewId())
                ->first();
        }

        if ($_value) {
            if ($_value->attribute_value != $value) {
                $_value->attribute_value = $value;
                $_value->save();
            }
        } else {
            $attribute->value()->create([
                'store_view_id' => ($this instanceof MultipleStoreViews) ? $this->getStoreViewId() : null,
                'attribute_value' => $value,
            ]);
        }
    }

    /**
     * Get Attribute
     */
    public function getAttribute($key)
    {
        if (isset($this->_getAttributes[$key])) {
            return \call_user_func_array ([$this, $this->_getAttributes[$key]], [$key]);
        }

        return parent::getAttribute($key);
    }

    /**
     * Set Attribute
     */
    public function setAttribute($key, $value)
    {
        if (isset($this->_setAttributes[$key])) {
            return \call_user_func_array ([$this, $this->_setAttributes[$key]], [$key, $value]);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Set attributes by object
     *
     * @param array $attributes
     */
    public function setAttributes(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }

        $this->save();

        return $this;
    }

    public function eavModel()
    {
        return $this->morphOne(Model::class, 'model');
    }

    public function scopeByAttribute(Builder $query, $key = null, $operator, $value): void
    {
        $query->whereHas('eavModel', function ($query) use ($key, $operator, $value) {
            $query->whereHas('attributes', function ($query) use ($key, $operator, $value) {
                $query->join('store_eav_entities', function ($entity) use ($key) {
                    $entity->on('store_eav_entities.id', '=', 'store_eav_attributes.entity_id')
                        ->where('store_eav_entities.entity_key', $key);
                })->join('store_eav_values', function ($qvalue) use ($operator, $value) {
                    $qvalue->on('store_eav_values.attribute_id', '=', 'store_eav_attributes.id')
                        ->where('store_eav_values.attribute_value', $operator, $value);
                });
            });
        });
    }
}
