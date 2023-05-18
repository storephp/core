<?php

namespace Store\Support\Services;

use Store\Support\Exceptions\Coupon\CouponAlreadyExists;
use Store\Support\Exceptions\Coupon\CouponNotFound;
use Store\Support\Repositories\CouponRepository;

class CouponService
{
    public function __construct(
        public CouponRepository $couponRepository
    ) {}

    public function getList($limit = null)
    {
        return $this->couponRepository->getByPaginate($limit);
    }

    public function getListWithSearch($search = null, $limit = null)
    {
        return $this->couponRepository->getBySearchWithPaginate($limit, $search);
    }

    public function createNewCoupon($data)
    {
        if ($this->couponRepository->checkByCode($data['coupon_code'])) {
            throw new CouponAlreadyExists();
        }

        return $this->couponRepository->create($data);
    }

    public function getCouponById($id)
    {
        if (!$this->couponRepository->checkById($id)) {
            throw new CouponNotFound();
        }

        return $this->couponRepository->getById($id);
    }

    public function updateCouponById(int $id, array $data)
    {
        if (!$this->couponRepository->checkById($id)) {
            throw new CouponNotFound();
        }

        $this->couponRepository->updateById($id, $data);
        return $this->couponRepository->getById($id);
    }
}
