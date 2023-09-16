<?php

namespace Store\Models;

use Store\Base\ModelBase;
use Store\Contracts\Model\IFinalPrice;
use Store\EAV\Contracts\MultipleStoreViews;
use Store\EAV\Traits\HasEAV;
use Store\EAV\Traits\HasStoreView;
use Store\Models\Product\Category;

class Product extends ModelBase implements IFinalPrice, MultipleStoreViews
{
    // use HasEntry;
    use HasEAV, HasStoreView;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
    ];

    protected $fillableEntities = [
        'categories',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'thumbnail_path',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'discount_price' => 'float',
    ];

    protected $appends = [
        'final_price',
        'discount_value',
    ];

    // public function getProductTypeAttribute($value)
    // {
    //     return match($value) {
    //         ProductType::CONFIGURABLE() => 'configurable',
    //         ProductType::SIMPLE() => 'simple',
    //     };
    // }

    public function fillableEntities()
    {
        return array_unique(
            array_merge(
                $this->fillableEntities,
                config('store.catalog.products.external_fillable_entry')
            )
        );
    }

    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    public function getDiscountValueAttribute()
    {
        $value = $this->price - $this->discount_price;
        return ($value == $this->price) ? 0 : (float) $value;
    }

    public function scopeConfigurableOnly($query)
    {
        return $query->whereNull('configurable_id');
    }

    public function configurable()
    {
        return $this->hasOne(Product::class, 'id', 'configurable_id');
    }

    public function simples()
    {
        return $this->hasMany(Product::class, 'configurable_id', 'id');
    }

    public function getCategories()
    {
        if (!$this->categories) {
            return [];
        }

        $categories = array_map(function ($categoryId) {
            return Category::find($categoryId);
        }, $this->categories);

        return array_filter($categories, function ($category) {
            if ($category) {
                return $category;
            }
        });
    }
}
