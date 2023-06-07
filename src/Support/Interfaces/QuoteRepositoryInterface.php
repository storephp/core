<?php

namespace Store\Support\Interfaces;

use Store\Models\Basket;
use Store\Models\Basket\Quote;

interface QuoteRepositoryInterface
{
    /**
     * Set basket for quotes management
     *
     * @param Basket $basket
     */
    public function setBasket(Basket $basket);

    /**
     * Create new quote
     *
     * @param array $data
     *
     * @return \Store\Models\Basket\Quote
     */
    public function create(array $data);

    /**
     * Get quotes list
     *
     * @return \Store\Models\Basket\Quote
     */
    public function getList();

    /**
     * Get quote by product sku
     *
     * @param mixed $productSku
     *
     * @return \Store\Models\Basket\Quote
     */
    public function getQuoteByProductSku(mixed $productSku);

    /**
     * Increase quantity
     *
     * @param Quote $quote
     * @param int $quantity
     *
     * @return \Store\Models\Basket\Quote
     */
    public function increase(Quote $quote, int $quantity): Quote;

    /**
     * Decrease quantity
     *
     * @param Quote $quote
     * @param int $quantity
     *
     * @return \Store\Models\Basket\Quote
     */
    public function decrease(Quote $quote, int $quantity): bool | Quote;

    /**
     * Delete quote
     *
     * @param Quote $quote
     */
    public function delete(Quote $quote);

    /**
     * Check whether this basket has quote or not
     */
    public function basketHasQuote();
}
