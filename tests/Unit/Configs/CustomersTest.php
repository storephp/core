<?php

declare (strict_types = 1);

test('testCustomersModelValue', function () {
    $config = config('outmart.customers.model');
    $this->assertEquals($config, \OutMart\Models\Customer::class);
});
