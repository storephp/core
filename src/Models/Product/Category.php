<?php

namespace OutMart\Models\Product;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use OutMart\Base\ModelBase;
use OutMart\Models\Traits\HasEntry;

class Category extends ModelBase
{
    use HasEntry;

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
        'slug',
    ];

    protected $fillableEntry = [
        'name',
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
            set:fn($value) => Str::slug($value, '-'),
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

    public function entries()
    {
        return $this->hasMany(CategoryEntry::class, 'category_id', 'id');
    }
}
