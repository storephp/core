<?php

declare (strict_types = 1);

use Store\Support\Repositories\CustomerRepository;
use Store\Support\Services\CustomerService;

it('gets a customer data', function () {
    $customerRepository = new CustomerRepository;
    $customerService = new CustomerService($customerRepository);

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    $customerService->setCustomerId($customer->id);

    $customer = $customerService->getData();

    expect($customer)->toMatchArray([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);
});

it('gets a customer data by key', function () {
    $customerRepository = new CustomerRepository;
    $customerService = new CustomerService($customerRepository);

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    $customerService->setCustomerId($customer->id);

    $customer = $customerService->getData('first_name');

    expect($customer)->toEqual('first');
});