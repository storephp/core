<?php

namespace Basketin\Repositories;

use Illuminate\Support\Str;
use Basketin\Enums\Baskets\Status;
use Basketin\Models\Basket;

class BasketRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Basket();
    }

    public function query()
    {
        return $this->model;
    }

    /**
     * Create new basket
     * 
     * @param string $currency
     * 
     * @return \Basketin\Models\Basket
     */
    public function createNewBasket(string $currency)
    {
        return $this->query()->create([
            'ulid' => (string) Str::ulid(),
            'currency' => $currency,
        ]);
    }

    /**
     * get available basket by basket ulid
     * 
     * @param string $ulid
     * 
     * @return \Basketin\Models\Basket
     */
    public function getAvailableBasket($ulid = null)
    {
        if (!$ulid) {
            return $ulid;
        }

        return $this->query()->whereUlid($ulid)
            ->whereIn('status', [Status::OPENED(), Status::ABANDONED()])
            ->first();
    }
}
