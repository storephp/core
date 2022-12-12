<?php

namespace Bidaea\OutMart\Modules\Baskets\Traits;

use Bidaea\OutMart\Modules\Baskets\Manage\BasketMethodManager;
use Bidaea\OutMart\Modules\Baskets\Models\Basket;

trait WithBasket
{
    public function basket()
    {
        return $this->morphOne(Basket::class, 'customer');
    }

    public function baskets()
    {
        return $this->morphMany(Basket::class, 'customer');
    }

    public function initBasket(string $basket_ulid = null, string $currency = 'USD'): BasketMethodManager
    {
        return new BasketMethodManager($basket_ulid, $currency, $this);
    }
}
