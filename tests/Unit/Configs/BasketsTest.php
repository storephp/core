<?php

declare(strict_types=1);

use OutMart\Tests\TestCase;

class BasketsTest extends TestCase
{
    public function testBasketsMaxQuoteValue(): void
    {
        $config = config('outmart.baskets.max_quote');
        $this->assertEquals($config, 10);
    }

    public function testBasketsProductRelationForeignKeyValue(): void
    {
        $config = config('outmart.baskets.product_relation.foreign_key');
        $this->assertEquals($config, 'sku');
    }

    public function testBasketsProductRelationModelValue(): void
    {
        $config = config('outmart.baskets.product_relation.model');
        $this->assertEquals($config, App\Models\Product::class);
    }

    public function testBasketsStatusesValue(): void
    {
        $config = config('outmart.baskets.statuses');
        $this->assertTrue(empty($config));
    }
}
