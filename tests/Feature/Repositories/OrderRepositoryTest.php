<?php

declare (strict_types = 1);

use Basketin\Support\Repositories\OrderRepository;

it('creates a new order', function () {
    $orderRepository = new OrderRepository;

    $order = $orderRepository->create([
        'sub_total' => 100,
        'grand_total' => 100,
    ]);

    expect($order)->toMatchArray([
        'sub_total' => 100,
        'grand_total' => 100,
    ]);
});

it('gets a order by id', function () {
    $orderRepository = new OrderRepository;

    $orderCreated = $orderRepository->create([
        'sub_total' => 100,
        'grand_total' => 100,
    ]);

    $order = $orderRepository->getById($orderCreated->id);

    expect($order)->toMatchArray([
        'sub_total' => 100,
        'grand_total' => 100,
    ]);
});
