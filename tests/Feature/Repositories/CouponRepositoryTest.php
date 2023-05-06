<?php

declare (strict_types = 1);

use Store\Support\Repositories\CouponRepository;

it('creates a new coupon', function () {
    $couponRepository = new CouponRepository;

    $coupon = $couponRepository->create([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);
});

it('gets a coupons by paginate', function () {
    $couponRepository = new CouponRepository;

    $couponRepository->create([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponRepository->getByPaginate()->first();

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);
});

it('gets a coupon by id', function () {
    $couponRepository = new CouponRepository;

    $couponCreated = $couponRepository->create([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponRepository->getById($couponCreated->id);

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);
});

it('checks the coupon exists by id', function () {
    $couponRepository = new CouponRepository;

    $couponCreated = $couponRepository->create([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponRepository->checkById($couponCreated->id);

    expect($coupon)->toBeTrue();
});

it('checks the coupon not exists by id', function () {
    $couponRepository = new CouponRepository;

    $coupon = $couponRepository->checkById(1);

    expect($coupon)->toBeFalse();
});

it('checks the coupon exists by code', function () {
    $couponRepository = new CouponRepository;

    $coupon = $couponRepository->create([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponRepository->checkByCode($coupon->coupon_code);

    expect($coupon)->toBeTrue();
});

it('checks the coupon not exists by code', function () {
    $couponRepository = new CouponRepository;

    $coupon = $couponRepository->checkByCode('test_1');

    expect($coupon)->toBeFalse();
});

it('updates a coupon', function () {
    $couponRepository = new CouponRepository;

    $couponCreated = $couponRepository->create([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponRepository->updateById($couponCreated->id, [
        'discount_value' => 20,
    ]);

    expect($coupon)->toBeTrue();
});
