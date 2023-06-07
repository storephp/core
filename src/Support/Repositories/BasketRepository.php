<?php

namespace Store\Support\Repositories;

use Illuminate\Support\Str;
use Store\Enums\Baskets\Status;
use Store\Models\Basket;
use Store\Support\Interfaces\BasketRepositoryInterface;

class BasketRepository implements BasketRepositoryInterface
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
     * @return \Store\Models\Basket
     */
    public function createNewBasket(string $currency): Basket
    {
        return $this->query()->create([
            'ulid' => (string) Str::ulid(),
            'currency' => $currency,
            'status' => Status::OPENED(),
        ]);
    }

    /**
     * get available basket by basket ulid
     *
     * @param string $ulid
     *
     * @return \Store\Models\Basket
     */
    public function getAvailableBasket($ulid = null): Null|Basket
    {
        if (!$ulid) {
            return null;
        }

        return $this->query()->whereUlid($ulid)
            ->whereIn('status', [Status::OPENED(), Status::ABANDONED()])
            ->first();
    }
}