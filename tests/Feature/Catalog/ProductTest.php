<?php

declare (strict_types = 1);

use Basketin\Models\Product;

test('test create new product', function () {
    $product = Product::create([
        'sku' => '123abc',
    ]);

    expect($product->sku)->toEqual('123abc');
});

test('test create new product with use EAV', function () {
    $product = Product::create([
        'sku' => '123abc',
    ]);

    $product->name = 'product top';
    $product->save();

    expect($product->name)->toEqual('product top');

});

test('test create new product with use EAV by `setAttributes` method', function () {
    $product = Product::create([
        'sku' => '123abc',
    ]);

    $product->setAttributes([
        'name' => 'product top',
    ]);

    expect($product->name)->toEqual('product top');

});

test('test create new product without use EAV', function () {
    $product = Product::create([
        'sku' => '123abc',
    ]);

    expect($product->name)->toBeNull();
});

test('test get product with have EAV', function () {
    $product = Product::create([
        'sku' => '123abc',
    ]);

    $product->name = 'product top';
    $product->save();

    $getProduct = Product::where('sku', '123abc')->first();

    expect($getProduct->name)->toEqual('product top');
});
