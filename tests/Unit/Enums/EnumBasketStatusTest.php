<?php

declare(strict_types=1);

use OutMart\Enums\Baskets\Status;
use OutMart\Tests\TestCase;

class EnumBasketStatusTest extends TestCase
{
    public function testStatusOpened(): void
    {
        $this->assertEquals(Status::OPENED(), 1);
    }

    public function testStatusAbandoned(): void
    {
        $this->assertEquals(Status::ABANDONED(), 2);
    }

    public function testStatusOrdered(): void
    {
        $this->assertEquals(Status::ORDERED(), 3);
    }
}
