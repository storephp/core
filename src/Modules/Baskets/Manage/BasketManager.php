<?php

namespace Bidaea\OutMart\Modules\Baskets\Manage;

use Bidaea\OutMart\Modules\Baskets\Models\Basket;
use Illuminate\Support\Str;

class BasketManager
{
    public function initBasket(string $basket_ulid = null, string $currency = 'USD', $customer = null): BasketMethodManager
    {
        if (!$basket_ulid) {
            $basket_ulid = (string) Str::ulid();
        }

        $basket = Basket::find($basket_ulid);

        if (!$basket) {
            $basket = Basket::create([
                'currency' => $currency,
            ]);
        }

        return new BasketMethodManager($basket, $customer);
    }
}
