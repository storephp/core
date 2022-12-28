<?php

declare(strict_types=1);

use OutMart\Tests\TestCase;

class DatabaseTest extends TestCase
{
    public function testDatabaseTablePrefixValue(): void
    {
        $config = config('outmart.database.table_prefix');
        $this->assertEquals($config, 'outmart_');
    }
}
