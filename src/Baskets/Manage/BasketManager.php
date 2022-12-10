<?php

namespace OutMart\Laravel\Baskets\Manage;

use Illuminate\Support\Str;
use OutMart\Laravel\Baskets\Models\Basket;

class BasketManager
{
    private $basketModel;

    public function initBasket(string $basket_ulid = null, string $currency = 'USD'): BasketManager
    {
        if (!$basket_ulid) {
            $basket_ulid = (string) Str::ulid();
        }

        $basket = Basket::find($basket_ulid);

        if (!$basket) {
            $basket = Basket::create([
                'currency' => $currency,
            ]);
        }

        $this->basketModel = $basket;

        return $this;
    }

    public function addQuotes(int $product_id, int $quantity = 1)
    {
        $item = $this->basketModel->quotes()->where('product_id', $product_id)->first();

        if (!$item) {
            $this->basketModel->quotes()->create([
                'product_id' => $product_id,
                'quantity' => $quantity,
            ]);
        }

        if ($item) {
            $item->increment('quantity', $quantity);
        }

        return $this;
    }

    public function quotes()
    {
        return $this->basketModel->quotes;
    }

    public function getBasketUlid(): String
    {
        return $this->basketModel->id;
    }
}
