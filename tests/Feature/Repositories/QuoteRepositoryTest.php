<?php

declare (strict_types = 1);

use Store\Models\Basket\Quote;
use Store\Support\Repositories\BasketRepository;
use Store\Support\Repositories\QuoteRepository;

it('creates a new basket', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quote = new QuoteRepository;
    $quote->setBasket($basket);

    $quoteCreated = $quote->create([
        'product_sku' => '123abc',
        'quantity' => 1,
    ]);

    expect($quoteCreated)->toMatchArray([
        'product_sku' => '123abc',
        'quantity' => 1,
    ]);
});

it('gets a quotes list', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quote = new QuoteRepository;
    $quote->setBasket($basket);

    $quote->create([
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);

    expect($quote->getList()->first())->toMatchArray([
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);
});

it('gets a quote by product SKU', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quote = new QuoteRepository;
    $quote->setBasket($basket);

    $quote->create([
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);

    expect($quote->getQuoteByProductSku('123abc'))->toMatchArray([
        'basket_id' => 1,
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);
});

it('increases quote', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quoteRepository = new QuoteRepository;
    $quoteRepository->setBasket($basket);

    $quoteRepository->create([
        'product_sku' => '123abc',
        'quantity' => 1,
    ]);

    $getQuote = $quoteRepository->getQuoteByProductSku('123abc');

    $quote = Quote::find($getQuote->id);

    expect($quoteRepository->increase($quote, 2))->toMatchArray([
        'basket_id' => 1,
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);
});

it('decreases quote', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quoteRepository = new QuoteRepository;
    $quoteRepository->setBasket($basket);

    $quoteRepository->create([
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);

    $getQuote = $quoteRepository->getQuoteByProductSku('123abc');

    $quote = Quote::find($getQuote->id);

    expect($quoteRepository->decrease($quote, 2))->toMatchArray([
        'basket_id' => 1,
        'product_sku' => '123abc',
        'quantity' => 1,
    ]);
});

it('deletes quote', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quoteRepository = new QuoteRepository;
    $quoteRepository->setBasket($basket);

    $quoteRepository->create([
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);

    $getQuote = $quoteRepository->getQuoteByProductSku('123abc');

    $quote = Quote::find($getQuote->id);

    expect($quoteRepository->delete($quote))->toBeTrue();
});

it('checks basket has quotes', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quoteRepository = new QuoteRepository;
    $quoteRepository->setBasket($basket);

    $quoteRepository->create([
        'product_sku' => '123abc',
        'quantity' => 3,
    ]);

    expect($quoteRepository->basketHasQuote())->toBeTrue();
});

it('checks the basket does not have quotes', function () {
    $basketRepository = new BasketRepository;
    $basket = $basketRepository->createNewBasket('USD');

    $quoteRepository = new QuoteRepository;
    $quoteRepository->setBasket($basket);

    expect($quoteRepository->basketHasQuote())->toBeFalse();
});
