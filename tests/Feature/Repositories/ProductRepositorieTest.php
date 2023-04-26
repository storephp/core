<?php

declare (strict_types = 1);

use Basketin\Support\Repositories\ProductRepositorie;

it('gets a products list', function () {
    $productRepositorie = new ProductRepositorie;

    $productRepositorie->create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
    ]);

    $products = $productRepositorie->all();

    expect($products->first())->toMatchArray([
        'sku' => '123abc',
    ]);
});

it('creates a new product', function () {
    $productRepositorie = new ProductRepositorie;

    $product = $productRepositorie->create([
        'sku' => '123abc',
    ]);

    expect($product->sku)->toEqual('123abc');
});

it('creates a new product with use EAV', function () {
    $productRepositorie = new ProductRepositorie;

    $product = $productRepositorie->create([
        'sku' => '123abc',
    ]);

    $product->name = 'product top';
    $product->save();

    expect($product->name)->toEqual('product top');
});

it('creates a new product with use EAV by `setAttributes` method', function () {
    $productRepositorie = new ProductRepositorie;

    $product = $productRepositorie->create([
        'sku' => '123abc',
    ]);

    $product->setAttributes([
        'name' => 'product top',
    ]);

    expect($product->name)->toEqual('product top');

});

it('creates a new product without use EAV', function () {
    $productRepositorie = new ProductRepositorie;

    $product = $productRepositorie->create([
        'sku' => '123abc',
    ]);

    expect($product->name)->toBeNull();
});

it('gets a product with have EAV', function () {
    $productRepositorie = new ProductRepositorie;

    $product = $productRepositorie->create([
        'sku' => '123abc',
    ]);

    $product->name = 'product top';
    $product->save();

    $getProduct = $productRepositorie->getBySku('123abc');

    expect($getProduct->name)->toEqual('product top');
});
