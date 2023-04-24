<?php

declare (strict_types = 1);

use Basketin\Models\Product;
use Basketin\Support\Facades\Basket;

it('creates a new basket', function () {
    $basket = Basket::initBasket();

    expect($basket->getUlid())->toBeString();
});

it('uses exist basket', function () {
    $newBasket = Basket::initBasket();;

    $basket = Basket::initBasket($newBasket->getUlid());

    expect($basket->getUlid())->toEqual($newBasket->getUlid());
});

it('add new quotes', function () {
    $basket = Basket::initBasket();

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
    $basket = Basket::initBasket();

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
    $basket = Basket::initBasket();

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
    $basket = Basket::initBasket();

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
    $basket = Basket::initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $quote = $basket->addQuotes($product->sku)->first();

    expect($basket->deleteQuote($quote))->toBeNull();
});

it('gets subtotal', function () {
    $basket = Basket::initBasket();

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
    $basket = Basket::initBasket();

    $product = Product::create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
        'price' => 100,

    ]);

    $basket->addQuotes($product->sku)->first();

    expect($basket->getTotal())->toEqual(100);
});
