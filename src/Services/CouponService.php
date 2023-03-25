<?php

namespace OutMart\Services;

use OutMart\Repositories\CouponRepository;
use OutMart\Services\Exceptions\Coupon\CouponAlreadyExists;

class CouponService
{
    public function __construct(
        public CouponRepository $couponRepository
    ) {}

    public function getList($limit = null)
    {
        return $this->couponRepository->getByPaginate($limit);
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
        if ($this->couponRepository->checkById($id)) {
            return $this->couponRepository->getById($id);
        }
    }

    public function updateCouponById(int $id, array $data)
    {
        if ($this->couponRepository->checkById($id)) {
            return $this->couponRepository->updateById($id, $data);
        }
    }
}
