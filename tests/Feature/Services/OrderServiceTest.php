<?php

declare (strict_types = 1);

use Store\Repositories\OrderAddressRepository;
use Store\Support\Repositories\BasketRepository;
use Store\Support\Repositories\CustomerRepository;
use Store\Support\Repositories\OrderRepository;
use Store\Support\Repositories\ProductRepository;
use Store\Support\Repositories\QuoteRepository;
use Store\Support\Services\BasketService;
use Store\Support\Services\CustomerService;
use Store\Support\Services\OrderService;

it('places new order', function () {
    $orderService = new OrderService(new OrderRepository, new OrderAddressRepository());

    ///
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $productRepository = new ProductRepository;

    $product = $productRepository->create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
        'price' => 100,
    ]);

    $basket->addQuotes($product->sku);
    ///

    ///
    $customerRepository = new CustomerRepository;
    $customerService = new CustomerService($customerRepository);

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    $customer = $customerService->setCustomerId($customer->id);
    ///

    $orderService->initOrder($basket, $customer);
    $orderService->placeOrder();

    $order = $orderService->getOrder();

    expect($order)->toMatchArray([
        'id' => 1,
        'grand_total' => 100,
    ]);
});

it('places new order with reverts this order', function () {
    $orderService = new OrderService(new OrderRepository, new OrderAddressRepository());

    ///
    $basketService = new BasketService(
        new BasketRepository,
        new QuoteRepository
    );

    $basket = $basketService->initBasket();

    $productRepository = new ProductRepository;

    $product = $productRepository->create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
        'price' => 100,
    ]);

    $basket->addQuotes($product->sku);
    ///

    ///
    $customerRepository = new CustomerRepository;
    $customerService = new CustomerService($customerRepository);

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    $customer = $customerService->setCustomerId($customer->id);
    ///

    $orderService->initOrder($basket, $customer);
    $orderService->placeOrder();

    $order = $orderService->getOrder();

    $revertIt = $orderService->revert($order->id);

    expect($revertIt)->toBeTrue();
});
