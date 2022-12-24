<?php

namespace OutMart\Manage\Baskets;

class BasketManager
{
    public function initBasket(string $basket_ulid = null, string $currency = 'USD', $customer = null): BasketMethodManager
    {
        return new BasketMethodManager($basket_ulid, $currency, $customer);
    }
}
