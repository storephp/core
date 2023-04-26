<?php

declare (strict_types = 1);

use Basketin\Support\Facades\Customer;
use Basketin\Support\Repositories\CustomerRepository;

it('gets a customer data', function () {
    $customerRepository = new CustomerRepository;

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    Customer::setCustomerId($customer->id);

    $customer = Customer::getData();

    expect($customer)->toMatchArray([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);
});

it('gets a customer data by key', function () {
    $customerRepository = new CustomerRepository;

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    Customer::setCustomerId($customer->id);

    $customer = Customer::getData('first_name');

    expect($customer)->toEqual('first');
});
