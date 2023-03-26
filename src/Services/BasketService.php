<?php

namespace OutMart\Services;

use OutMart\Exceptions\Baskets\QuoteExceedingLimitException;
use OutMart\Exceptions\Baskets\QuoteTheMaxException;
use OutMart\Models\Basket\Quote;
use OutMart\Repositories\BasketRepository;
use OutMart\Repositories\QuoteRepository;

class BasketService
{
    public $currentBasket = null;

    public function __construct(
        public BasketRepository $basketRepository,
        public QuoteRepository $quoteRepository,
    ) {}

    public function initBasket($ulid = null)
    {
        $basket = $this->basketRepository->getAvailableBasket($ulid);

        // dd($ulid, $basket);

        if (!$basket) {
            $basket = $this->basketRepository->createNewBasket('EGP');
        }

        $this->currentBasket = $basket;
        $this->quoteRepository->setBasket($basket);

        return $this;
    }

    public function getCurrency()
    {
        return $this->currentBasket->currency;
    }

    public function getUlid()
    {
        return $this->currentBasket->ulid;
    }

    public function addQuotes($productSku, int $quantity = 1)
    {
        $quote = $this->quoteRepository->getQuoteByProductSku($productSku);

        if (!$quote) {
            return $this->quoteRepository->create([
                'basket_id' => $this->currentBasket->id,
                'product_sku' => $productSku,
                'quantity' => $quantity,
            ]);
        }

        return $this->quoteRepository->increase($quote, $quantity);
    }

    public function increase(Quote $quote, int $quantity)
    {
        if ($quote->quantity >= config('outmart.baskets.max_quote')) {
            throw new QuoteTheMaxException();
        }

        return $this->quoteRepository->increase($quote, $quantity);
    }

    public function decrease(Quote $quote, int $quantity)
    {
        if ($quote->quantity <= $quantity) {
            $this->quoteRepository->delete($quote);
            return false;
        }

        if ($quantity < $quantity) {
            throw new QuoteExceedingLimitException();
        }

        return $this->quoteRepository->decrease($quote, $quantity);
    }
}
