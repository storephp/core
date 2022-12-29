<?php

namespace OutMart\Models\Product;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use OutMart\Base\ModelBase;

class Category extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'catalog_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
    ];

    public function hasChildren()
    {
        return $this->children()->exists();
    }

    /**
     * Interact with the category slug.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::slug($value, '-'),
        );
    }

    /**
     * Return the parent category relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    /**
     * Return the children's categories' relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
