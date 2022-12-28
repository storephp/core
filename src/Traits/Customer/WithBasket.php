<?php

namespace OutMart\Traits\Customer;

use Illuminate\Support\Str;
use OutMart\Models\Basket;
use OutMart\Enums\Baskets\Status;

trait WithBasket
{
    public function basket()
    {
        return $this->morphOne(Basket::class, 'customer');
    }

    public function baskets()
    {
        return $this->morphMany(Basket::class, 'customer');
    }

    public function currentBasket(string $basket_ulid = null, string $currency = 'USD')
    {
        $basket = $this->basket()
            ->whereUlid($basket_ulid)
            ->whereIn('status', [Status::OPENED(), Status::ABANDONED()])
            ->first();

        if ($basket) {
            return $basket;
        }

        return $this->basket()->create([
            'ulid' => $basket_ulid ?? (string) Str::ulid(),
            'currency' => $currency,
        ]);
    }
}
