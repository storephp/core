<?php

declare(strict_types=1);

use OutMart\Tests\TestCase;

class CustomersTest extends TestCase
{
    public function testCustomersModelValue(): void
    {
        $config = config('outmart.customers.model');
        $this->assertEquals($config, \OutMart\Models\Customer::class);
    }
}
