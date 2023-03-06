<?php

namespace OutMart\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait HasEntry
{
    private $storeViewId = null;

    public function __get($key)
    {
        $withOutFillable = array_merge([$this->getKeyName(), 'parent'], $this->getDates(), $this->fillable);

        if (in_array($key, $withOutFillable)) {
            return $this->getAttribute($key);
        }

        if ($entry = $this->getEntry($key, $this->getStoreViewId())) {
            $entryMethodName = 'get' . Str::studly($key) . 'Entry';
            if (method_exists($this, $entryMethodName)) {
                $entry = call_user_func_array([$this, $entryMethodName], [$entry]);
            }
            return $entry;
        }
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function __set($key, $value)
    {
        $withOutFillable = array_merge($this->getDates(), $this->fillable);

        if (in_array($key, $withOutFillable)) {
            return $this->setAttribute($key, $value);
        }

        return $this->setEntry($key, $value, $this->getStoreViewId());
    }

    public function getEntry($key, $storeViewId = null)
    {
        $entry = $this->entries()->where('store_view_id', $storeViewId)->where('entry_key', $key)->first();
        if (!$entry) {
            $entry = $this->entries()->whereNull('store_view_id')->where('entry_key', $key)->first();
        }
        return $entry->entry_value ?? null;
    }

    public function setEntry($key, $value, $storeViewId = null)
    {
        if (!is_null($value)) {
            if ($entry = $this->entries()->where('store_view_id', $storeViewId)->where('entry_key', $key)->first()) {
                $entry->entry_value = $value;
                $entry->save();
                return $entry;
            }

            $entryExistsAtDefaultStoreView = $this->entries()
                ->where('store_view_id', 1)
                ->where('entry_key', $key)
                ->where('entry_value', $value)
                ->exists();

            if (!$entryExistsAtDefaultStoreView) {
                return $this->entries()->create([
                    'store_view_id' => $storeViewId,
                    'entry_key' => $key,
                    'entry_value' => $value,
                ]);
            }
        }
    }

    public function scopeByEntry(Builder $query, $key = null, $operator, $value): void
    {
        $query->whereHas('entries', function ($query) use ($key, $operator, $value) {
            $query->where('entry_key', $key)
                ->where('entry_value', $operator, $value);
        });
    }

    public function scopeOrByEntry(Builder $query, $key = null, $operator, $value): void
    {
        $query->orWhereHas('entries', function ($query) use ($key, $operator, $value) {
            $query->where('entry_key', $key)
                ->where('entry_value', $operator, $value);
        });
    }

    /**
     * Get the value of storeViewId
     */
    public function getStoreViewId()
    {
        return $this->storeViewId;
    }

    /**
     * Set the value of storeViewId
     *
     * @return  self
     */
    public function setStoreViewId($storeViewId)
    {
        $this->storeViewId = $storeViewId;

        return $this;
    }
}
