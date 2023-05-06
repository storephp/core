<?php

declare (strict_types = 1);

use Store\Models\Product;
use Store\Support\Repositories\BasketRepository;
use Store\Support\Repositories\QuoteRepository;
use Store\Support\Services\BasketService;

it('creates a new basket', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    expect($basket->getUlid())->toBeString();
});

it('uses exist basket', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $newBasket = $basketService->initBasket();

    $basket = $basketService->initBasket($newBasket->getUlid());

    expect($basket->getUlid())->toEqual($newBasket->getUlid());
});

it('add new quotes', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $quote = $basket->addQuotes($product->sku);

    expect($quote)->toMatchArray([
        'product_sku' => '123abc',
        'quantity' => 1,
    ]);
});

it('gets quotes', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $basket->addQuotes($product->sku);

    expect($basket->getQuotes()->first())->toMatchArray([
        'product_sku' => '123abc',
        'quantity' => 1,
    ]);
});

it('increases quotes', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $quote = $basket->addQuotes($product->sku)->first();
    $basket->increase($quote, 1);

    expect($quote)->toMatchArray([
        'product_sku' => '123abc',
        'quantity' => 2,
    ]);
});

it('decreases quotes', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $quote = $basket->addQuotes($product->sku)->first();
    $basket->increase($quote, 1);
    $basket->decrease($quote, 1);

    expect($quote)->toMatchArray([
        'product_sku' => '123abc',
        'quantity' => 1,
    ]);
});

it('deletes quotes', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $quote = $basket->addQuotes($product->sku)->first();

    expect($basket->deleteQuote($quote))->toBeNull();
});

it('gets subtotal', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
        'price' => 100,

    ]);

    $basket->addQuotes($product->sku)->first();

    expect($basket->getSubTotal())->toEqual(100);
});


it('gets total', function () {
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
        'price' => 100,

    ]);

    $basket->addQuotes($product->sku)->first();

    expect($basket->getTotal())->toEqual(100);
});
