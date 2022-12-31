<?php

namespace OutMart\Events\Basket;

use Illuminate\Foundation\Events\Dispatchable;
use OutMart\Models\Basket;

class BasketCreating
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
