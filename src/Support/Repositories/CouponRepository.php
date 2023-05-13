<?php

namespace Store\Support\Repositories;

use Store\Models\Basket\Coupon;

class CouponRepository
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

    public function create($data)
    {
        return $this->query()->create($data);
    }

    public function getByPaginate($limit = 15)
    {
        return $this->query()->paginate($limit);
    }

    public function getById($id)
    {
        return $this->query()->find($id);
    }

    public function checkById($id)
    {
        return $this->query()->whereId($id)->exists();
    }

    public function checkByCode($code)
    {
        return $this->query()->where('coupon_code', $code)->exists();
    }

    public function updateById(int $id, array $data)
    {
        return $this->query()->find($id)->update($data);
    }
}
