<?php

declare(strict_types=1);

use OutMart\Enums\Catalog\ProductType;
use OutMart\Tests\TestCase;

class EnumCatalogProductTypeTest extends TestCase
{
    public function testTypeConfigurable(): void
    {
        $this->assertEquals(ProductType::CONFIGURABLE(), 1);
    }

    public function testTypeSimple(): void
    {
        $this->assertEquals(ProductType::SIMPLE(), 2);
    }
}
