<?php

namespace Bidaea\OutMart\Modules\Catalogs\Manage;

use Bidaea\OutMart\Modules\Catalogs\Models\Category;

class CategoryManager extends Category
{
    /**
     * Remove category by id.
     */
    public function removeIt($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Check category has children or not.
     */
    public function hasChildren($id)
    {
        return $this->find($id)->children()->exists();
    }
}
