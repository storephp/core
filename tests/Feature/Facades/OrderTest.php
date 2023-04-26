<?php

declare (strict_types = 1);

use Basketin\Support\Facades\Basket;
use Basketin\Support\Facades\Customer;
use Basketin\Support\Facades\Order;
use Basketin\Support\Repositories\CustomerRepository;
use Basketin\Support\Repositories\ProductRepositorie;

it('places new order', function () {
    ///
    $basket = Basket::initBasket();

    $productRepositorie = new ProductRepositorie;

    $product = $productRepositorie->create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
        'price' => 100,
    ]);

    $basket->addQuotes($product->sku);
    ///

    ///
    $customerRepository = new CustomerRepository;

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    $customer = Customer::setCustomerId($customer->id);
    ///

    Order::initOrder($basket, $customer);
    Order::placeOrder();

    $order = Order::getOrder();

    expect($order)->toMatchArray([
        'id' => 1,
        'grand_total' => 100,
    ]);
});

it('places new order with reverts this order', function () {
    ///
    $basket = Basket::initBasket();

    $productRepositorie = new ProductRepositorie;

    $product = $productRepositorie->create([
        'sku' => '123abc',
    ])->setAttributes([
        'name' => 'product top',
        'price' => 100,
    ]);

    $basket->addQuotes($product->sku);
    ///

    ///
    $customerRepository = new CustomerRepository;

    $customer = $customerRepository->create([
        'first_name' => 'first',
        'last_name' => 'last',
        'email' => 'customer@mail.test',
    ]);

    $customer = Customer::setCustomerId($customer->id);
    ///

    Order::initOrder($basket, $customer);
    Order::placeOrder();

    $order = Order::getOrder();

    $revertIt = Order::revert($order->id);

    expect($revertIt)->toBeTrue();
});
