<?php

declare (strict_types = 1);

use Basketin\Support\Exceptions\Coupon\CouponNotFound;
use Basketin\Support\Repositories\CouponRepository;
use Basketin\Support\Services\CouponService;

it('gets a coupons list', function () {
    $couponService = new CouponService(new CouponRepository);

    $couponService->createNewCoupon([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponService->getList()->first();

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);
});

it('creates a new coupon', function () {
    $couponService = new CouponService(new CouponRepository);

    $coupon = $couponService->createNewCoupon([
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

it('gets a coupon by id', function () {
    $couponService = new CouponService(new CouponRepository);

    $couponCreated = $couponService->createNewCoupon([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponService->getCouponById($couponCreated->id);

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);
});

it('gets a coupon by id not exist', function () {
    $couponService = new CouponService(new CouponRepository);

    expect(fn() => $couponService->getCouponById(1))
        ->toThrow(CouponNotFound::class, 'Coupon not found');
});

it('updates a coupon by id', function () {
    $couponService = new CouponService(new CouponRepository);

    $couponCreated = $couponService->createNewCoupon([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = $couponService->updateCouponById($couponCreated->id, [
        'discount_value' => 20,
    ]);

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 20,
        'is_active' => true,
    ]);
});

it('updates a coupon not exist', function () {
    $couponService = new CouponService(new CouponRepository);

    expect(fn() => $couponService->updateCouponById(1, [
        'discount_value' => 20,
    ]))->toThrow(CouponNotFound::class, 'Coupon not found');
});
