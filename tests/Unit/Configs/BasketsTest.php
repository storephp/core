<?php

declare (strict_types = 1);

test('testBasketsMaxQuoteValue', function () {
    $config = config('store.baskets.max_quote');
    $this->assertEquals($config, 10);
});

test('testBasketsProductRelationForeignKeyValue', function () {
    $config = config('store.baskets.product_relation.foreign_key');
    $this->assertEquals($config, 'sku');
});

test('testBasketsProductRelationModelValue', function () {
    $config = config('store.baskets.product_relation.model');
    $this->assertEquals($config, Store\Models\Product::class);
});

test('testBasketsStatusesValue', function () {
    $config = config('store.baskets.statuses');
    $this->assertTrue(empty($config));
});
