<?php

namespace Store\Support\Interfaces;

use Store\Models\Basket;

interface BasketRepositoryInterface
{
    /**
     * Create new basket
     *
     * @param string $currency
     *
     * @return \Store\Models\Basket
     */
    public function createNewBasket(string $currency): Basket;

    /**
     * get available basket by basket ulid
     *
     * @param string $ulid
     *
     * @return \Store\Models\Basket
     */
    public function getAvailableBasket($ulid = null): null|Basket;
}
