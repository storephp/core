<?php

declare (strict_types = 1);

use Basketin\Repositories\CouponRepository;
use Basketin\Services\CouponService;
use Basketin\Support\Exceptions\Coupon\CouponNotFound;
use Basketin\Support\Facades\Coupon;

it('gets a coupons list', function () {
    Coupon::createNewCoupon([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = Coupon::getList()->first();

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);
});

it('creates a new coupon', function () {
    $coupon = Coupon::createNewCoupon([
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
    $couponCreated = Coupon::createNewCoupon([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = Coupon::getCouponById($couponCreated->id);

    expect($coupon)->toMatchArray([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);
});

it('gets a coupon by id not exist', function () {
    expect(fn() => Coupon::getCouponById(1))
        ->toThrow(CouponNotFound::class, 'Coupon not found');
});

it('updates a coupon by id', function () {
    $couponCreated = Coupon::createNewCoupon([
        'coupon_name' => 'Test1',
        'coupon_code' => 'test_1',
        'discount_type' => 'percentage',
        'discount_value' => 10,
        'is_active' => true,
    ]);

    $coupon = Coupon::updateCouponById($couponCreated->id, [
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
    expect(fn() => Coupon::updateCouponById(1, [
        'discount_value' => 20,
    ]))->toThrow(CouponNotFound::class, 'Coupon not found');
});
