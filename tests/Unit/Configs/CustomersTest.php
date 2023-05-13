<?php

declare (strict_types = 1);

test('testCustomersModelValue', function () {
    $config = config('basketin.customers.model');
    $this->assertEquals($config, \Basketin\Models\Customer::class);
});
