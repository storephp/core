<?php

namespace OutMart\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Pharaonic\Laravel\Helpers\Traits\HasCustomAttributes;

trait HasEntry
{
    use HasCustomAttributes;

    private $storeViewId = null;
    private $entriesList = null;

    public function initializeHasEntry()
    {
        $fillableEntry = (method_exists($this, 'fillableEntry')) ? $this->fillableEntry() : $this->fillableEntry;

        foreach ($fillableEntry as $key) {
            $this->addGetterAttribute($key, 'getEntries');
            $this->addSetterAttribute($key, 'setEntries');
        }
    }

    private function getEntries($key)
    {
        if (!$this->entriesList) {
            $this->entriesList = $this->entries()->where(fn($q) => $q->where('store_view_id', null)->orWhere('store_view_id', $this->storeViewId))->get()->groupBy('store_view_id');
        }

        return $this->entriesList[$this->storeViewId]->where('entry_key', $key)->first()?->entry_value ?? $this->entriesList[""]->where('entry_key', $key)->first()?->entry_value ?? null;
    }

    private function setEntries($key, $value)
    {
        $this->setEntry($key, $value, $this->storeViewId);
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
