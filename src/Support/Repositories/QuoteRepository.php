<?php

namespace Store\Support\Repositories;

use Store\Models\Basket;
use Store\Models\Basket\Quote;
use Store\Support\Interfaces\QuoteRepositoryInterface;

class QuoteRepository implements QuoteRepositoryInterface
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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->basket->quotes()->create($data);
    }

    /**
     * Get quotes list
     *
     * @return \Store\Models\Basket\Quote
     */
    public function getList()
    {
        return $this->basket->quotes;
    }

    /**
     * Get quote by product sku
     *
     * @param mixed $productSku
     *
     * @return \Store\Models\Basket\Quote
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
     * @return \Store\Models\Basket\Quote
     */
    public function increase(Quote $quote, int $quantity) : Quote
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
     * @return \Store\Models\Basket\Quote
     */
    public function decrease(Quote $quote, int $quantity) : bool|Quote
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
            return true;
        }

        return false;
    }

    /**
     * Check whether this basket has quote or not
     */
    public function basketHasQuote()
    {
        return $this->basket->quotes()->exists();
    }
}