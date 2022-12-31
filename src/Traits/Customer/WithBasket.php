<?php

namespace OutMart\Traits\Customer;

use Illuminate\Support\Str;
use OutMart\Models\Basket;
use OutMart\Enums\Baskets\Status;
use OutMart\Models\Customer;

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
        $assignBasket = Basket::whereUlid($basket_ulid)
            ->whereIn('status', [Status::OPENED(), Status::ABANDONED()])
            ->first();

        if ($assignBasket) {
            $assignBasket->customer_type = config('outmart.customers.model', Customer::class);
            $assignBasket->customer_id = $this->id;
            $assignBasket->save();
            return $assignBasket;
        }

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
