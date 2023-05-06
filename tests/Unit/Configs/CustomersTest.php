<?php

declare (strict_types = 1);

test('testCustomersModelValue', function () {
    $config = config('store.customers.model');
    $this->assertEquals($config, \Store\Models\Customer::class);
});
