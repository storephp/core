<?php

declare(strict_types=1);

use Store\Enums\Catalog\ProductType;

test('test type configurable', function () {
    $this->assertEquals(ProductType::CONFIGURABLE(), 1);
});

test('test type simple', function () {
    $this->assertEquals(ProductType::SIMPLE(), 2);
});