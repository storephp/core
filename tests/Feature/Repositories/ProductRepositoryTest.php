<?php

declare (strict_types = 1);

use Basketin\Support\Repositories\ProductRepository;

it('gets a products list', function () {
    $productRepository = new ProductRepository;

    $productRepository->create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $products = $productRepository->all();

    expect($products->first())->toMatchArray([
        'sku' => '123abc',
    ]);
});

it('creates a new product', function () {
    $productRepository = new ProductRepository;

    $product = $productRepository->create([
        'sku' => '123abc',
    ]);

    expect($product->sku)->toEqual('123abc');
});

it('creates a new product with use EAV', function () {
    $productRepository = new ProductRepository;

    $product = $productRepository->create([
        'sku' => '123abc',
    ]);

    $product->name = 'product top';
    $product->save();

    expect($product->name)->toEqual('product top');
});

it('creates a new product with use EAV by `setAttributes` method', function () {
    $productRepository = new ProductRepository;

    $product = $productRepository->create([
        'sku' => '123abc',
    ]);

    $product->setAttributes([
        'name' => 'product top',
    ]);

    expect($product->name)->toEqual('product top');

});

it('creates a new product without use EAV', function () {
    $productRepository = new ProductRepository;

    $product = $productRepository->create([
        'sku' => '123abc',
    ]);

    expect($product->name)->toBeNull();
});

it('gets a product with have EAV', function () {
    $productRepository = new ProductRepository;

    $product = $productRepository->create([
        'sku' => '123abc',
    ]);

    $product->name = 'product top';
    $product->save();

    $getProduct = $productRepository->getBySku('123abc');

    expect($getProduct->name)->toEqual('product top');
});
