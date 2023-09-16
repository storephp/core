<?php

namespace Store\Support\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Store\Models\Basket\Coupon;

interface CouponRepositoryInterface
{
    /**
     * Create new coupon
     *
     * @param array $data
     *
     * @return \Store\Models\Basket\Coupon
     */
    public function create($data) : Coupon;

    /**
     * Listing coupons by paginate
     *
     * @param int $limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getByPaginate($limit) : LengthAwarePaginator;

    /**
     * Listing coupons by Search with paginate
     *
     * @param int $limit
     * @param string $search
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getBySearchWithPaginate($limit, $search) : LengthAwarePaginator;

    /**
     * Get coupon by id
     *
     * @param int $id
     *
     * @return \Store\Models\Basket\Coupon
     */
    public function getById($id) : Coupon;

    /**
     * Check coupon is exists by id
     *
     * @param int $id
     *
     * @return bool
     */
    public function checkById($id) : bool;

    /**
     * Check coupon is exists by code
     *
     * @param string $code
     *
     * @return bool
     */
    public function checkByCode($code) : bool;

    /**
     * Update coupon by id
     *
     * @param int $id
     * @param array $data
     *
     * @return bool
     */
    public function updateById(int $id, array $data) : bool;
}