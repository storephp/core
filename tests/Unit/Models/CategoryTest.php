<?php

declare(strict_types=1);

use OutMart\Tests\Core\Models\User;
use OutMart\Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testCreateUserIsCustomer(): void
    {
        $user = User::create([
            'name' => 'Karim Mohamed',
            'email' => 'komicho1996@gmail.com',
            'password' => 'password',
        ]);

        $customer = $user->signCustomer();

        $this->assertEquals($customer->customerable_id, 1);
    }
}
