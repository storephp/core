<?php

namespace Basketin\Events\Basket;

use Illuminate\Foundation\Events\Dispatchable;
use Basketin\Models\Basket;

class BasketUpdated
{
    use Dispatchable;

    public $basket;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }
}
