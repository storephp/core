<?php

namespace Basketin\EAV\Traits;

use Basketin\EAV\Contracts\IStoreView;
use Basketin\EAV\Contracts\MultipleStoreViews;
use Basketin\Models\EAV\Entity;
use Basketin\Models\EAV\Model;

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
            return \call_user_func_array([$this, $this->_getAttributes[$key]], [$key]);
        }

        return parent::getAttribute($key);
    }

    /**
     * Set Attribute
     */
    public function setAttribute($key, $value)
    {
        if (isset($this->_setAttributes[$key])) {
            return \call_user_func_array([$this, $this->_setAttributes[$key]], [$key, $value]);
        }

        return parent::setAttribute($key, $value);
    }

    public function eavModel()
    {
        return $this->morphOne(Model::class, 'model');
    }
}
