<?php

declare (strict_types = 1);

use Basketin\Repositories\OrderAddressRepository;
use Basketin\Support\Repositories\BasketRepository;
use Basketin\Support\Repositories\CustomerRepository;
use Basketin\Support\Repositories\OrderRepository;
use Basketin\Support\Repositories\ProductRepository;
use Basketin\Support\Repositories\QuoteRepository;
use Basketin\Support\Services\BasketService;
use Basketin\Support\Services\CustomerService;
use Basketin\Support\Services\OrderService;

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
