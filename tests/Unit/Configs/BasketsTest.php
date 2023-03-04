<?php

declare (strict_types = 1);

test('testBasketsMaxQuoteValue', function () {
    $config = config('outmart.baskets.max_quote');
    $this->assertEquals($config, 10);
});

test('testBasketsProductRelationForeignKeyValue', function () {
    $config = config('outmart.baskets.product_relation.foreign_key');
    $this->assertEquals($config, 'sku');
});

test('testBasketsProductRelationModelValue', function () {
    $config = config('outmart.baskets.product_relation.model');
    $this->assertEquals($config, OutMart\Models\Product::class);
});

test('testBasketsStatusesValue', function () {
    $config = config('outmart.baskets.statuses');
    $this->assertTrue(empty($config));
});
