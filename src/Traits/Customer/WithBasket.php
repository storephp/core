<?php

namespace Store\Traits\Customer;

use Exception;
use Illuminate\Support\Str;
use Store\Models\Basket;
use Store\Enums\Baskets\Status;
use Store\Models\Customer;

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
        if (Basket::whereUlid($basket_ulid)->where('status', Status::ORDERED())->exists()) {
            throw new Exception("The ULID for this basket already exists");
        }

        $assignBasket = Basket::whereUlid($basket_ulid)
            ->whereIn('status', [Status::OPENED(), Status::ABANDONED()])
            ->first();

        if ($assignBasket) {
            $assignBasket->customer_type = config('store.customers.model', Customer::class);
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
