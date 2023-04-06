<?php

declare (strict_types = 1);

use Basketin\Tests\Core\Models\User;

test('Create new customer', function () {
    $user = User::create([
        'name' => 'Karim Mohamed',
        'email' => 'komicho1996@gmail.com',
        'password' => 'password',
    ]);

    $customer = $user->signCustomer();

    $this->assertEquals($customer->customerable_id, 1);
});
