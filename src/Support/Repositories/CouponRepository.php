<?php

namespace Store\Support\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Store\Models\Basket\Coupon;
use Store\Support\Interfaces\CouponRepositoryInterface;

class CouponRepository implements CouponRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new Coupon;
    }

    public function query()
    {
        return $this->model;
    }

    /**
     * Create new coupon
     *
     * @param array $data
     *
     * @return \Store\Models\Basket\Coupon
     */
    public function create($data) : Coupon
    {
        return $this->query()->create($data);
    }

    /**
     * Listing coupons by paginate
     *
     * @param int $limit
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getByPaginate($limit = 15) : LengthAwarePaginator
    {
        return $this->query()->paginate($limit);
    }

    /**
     * Listing coupons by Search with paginate
     *
     * @param int $limit
     * @param string $search
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getBySearchWithPaginate($limit = 15, $search = null) : LengthAwarePaginator
    {
        return $this->query()->where(function ($q) use ($search) {
            if ($search) {
                $q->where('coupon_name', 'like', '%' . $search . '%')
                    ->orWhere('coupon_code', 'like', '%' . $search . '%');
            }
        })->paginate($limit);
    }

    /**
     * Get coupon by id
     *
     * @param int $id
     *
     * @return \Store\Models\Basket\Coupon
     */
    public function getById($id) : Coupon
    {
        return $this->query()->find($id);
    }

    /**
     * Check coupon is exists by id
     *
     * @param int $id
     *
     * @return bool
     */
    public function checkById($id) : bool
    {
        return $this->query()->whereId($id)->exists();
    }

    /**
     * Check coupon is exists by code
     *
     * @param string $code
     *
     * @return bool
     */
    public function checkByCode($code) : bool
    {
        return $this->query()->where('coupon_code', $code)->exists();
    }

    /**
     * Update coupon by id
     *
     * @param int $id
     * @param array $data
     *
     * @return bool
     */
    public function updateById(int $id, array $data) : bool
    {
        return $this->query()->find($id)->update($data);
    }
}