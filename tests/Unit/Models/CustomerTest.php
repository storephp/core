<?php

declare (strict_types = 1);

use Store\Models\Customer;

test('Create new customer', function () {
    $customer = Customer::create([
        'name' => 'Karim Mohamed',
        'email' => 'komicho1996@gmail.com',
        'password' => 'password',
    ]);

    $this->assertEquals($customer->id, 1);
});
