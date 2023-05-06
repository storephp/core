<?php

declare (strict_types = 1);

use Store\Support\Repositories\BasketRepository;

it('creates a new basket', function () {
    $basketRepository = new BasketRepository;

    $basket = $basketRepository->createNewBasket('USD');

    expect($basket)->toMatchArray([
        'currency' => 'USD',
    ]);
});

it('gets the available basket', function () {
    $basketRepository = new BasketRepository;

    $basket = $basketRepository->createNewBasket('USD');

    $basketAvailable = $basketRepository->getAvailableBasket($basket->ulid);

    expect($basketAvailable)->toMatchArray([
        'ulid' => $basket->ulid,
        'currency' => 'USD',
    ]);
});
