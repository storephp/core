<?php

declare (strict_types = 1);

use Basketin\Support\Repositories\CustomerRepository;

it('creates a new customer', function () {
    $customerRepository = new CustomerRepository;

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    expect($customer)->toMatchArray([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);
});

it('gets a customer by id', function () {
    $customerRepository = new CustomerRepository;

    $customerCreated = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    $customer = $customerRepository->getById($customerCreated->id);

    expect($customer)->toMatchArray([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);
});
