<?php

namespace Basketin\Support\Services;

use Basketin\Services\Exceptions\Coupon\CouponAlreadyExists;
use Basketin\Support\Exceptions\Coupon\CouponNotFound;
use Basketin\Support\Repositories\CouponRepository;

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
