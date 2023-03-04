<?php

declare (strict_types = 1);

use OutMart\Enums\Baskets\Status;

test('test status opened', function () {
    $this->assertEquals(Status::OPENED(), 1);
});

test('test status abandoned', function () {
    $this->assertEquals(Status::ABANDONED(), 2);
});

test('test status ordered', function () {
    $this->assertEquals(Status::ORDERED(), 3);
});
