<?php

namespace OutMart\Events\Basket\Quote;

use Illuminate\Foundation\Events\Dispatchable;
use OutMart\Models\Basket\Quote;

class QuoteIncrease
{
    use Dispatchable;

    public $quote;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;
    }
}
