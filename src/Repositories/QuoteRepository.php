<?php

namespace OutMart\Repositories;

use OutMart\Models\Basket;
use OutMart\Models\Basket\Quote;

class QuoteRepository
{
    private $basket;

    /**
     * Set basket for quotes management
     *
     * @param Basket $basket
     */
    public function setBasket(Basket $basket)
    {
        $this->basket = $basket;
    }

    /**
     * Create new quote
     *
     * @param array $data
     *
     * @return \OutMart\Models\Basket\Quote
     */
    public function create(array $data)
    {
        return $this->basket->quotes()->create($data);
    }

    /**
     * Get quote by product sku
     *
     * @param mixed $productSku
     *
     * @return \OutMart\Models\Basket\Quote
     */
    public function getQuoteByProductSku(mixed $productSku)
    {
        $quote = $this->basket->quotes()
            ->where('product_sku', $productSku)
            ->first();

        return $quote;
    }

    /**
     * Increase quantity
     *
     * @param Quote $quote
     * @param int $quantity
     *
     * @return \OutMart\Models\Basket\Quote
     */
    public function increase(Quote $quote, int $quantity): Quote
    {
        $quote->increment('quantity', $quantity);
        return $quote;
    }

    /**
     * Decrease quantity
     *
     * @param Quote $quote
     * @param int $quantity
     *
     * @return \OutMart\Models\Basket\Quote
     */
    public function decrease(Quote $quote, int $quantity): bool | Quote
    {
        $quote->decrement('quantity', $quantity);
        return $quote;
    }

    /**
     * Delete quote
     * 
     * @param Quote $quote
     */
    public function delete(Quote $quote)
    {
        if ($quote) {
            $quote->delete();
        }
    }
}
