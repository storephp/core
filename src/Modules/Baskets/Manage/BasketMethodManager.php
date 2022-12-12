<?php

namespace Bidaea\OutMart\Modules\Baskets\Manage;

class BasketMethodManager
{
    private $basketModel;

    public function __construct($basketModel, $customer = null)
    {
        $this->basketModel = $basketModel;

        if (
            $customer && $customer instanceof \App\Models\OutMart\Customer
            || $customer && $customer instanceof \Bidaea\OutMart\Modules\Customers\Models\Customer
        ) {
            $this->basketModel->customer_type = $customer::class;
            $this->basketModel->customer_id = $customer->id;
            $this->basketModel->save();
        }
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

    public function getBasket()
    {
        $quotes = $this->basketModel->quotes->map(function ($quote) {
            return [
                'id' => $quote->id,
                'quantity' => $quote->quantity,
                'product_name' => $quote->product->name,
                'product_price' => (float) $quote->product->price,
                'subtotal' => (float) $quote->quantity * $quote->product->price,
            ];
        });

        $count_products = 0;
        $count_items = 0;
        $subtotal = 0;

        foreach ($quotes as $quote) {
            $count_products = count($quotes);
            $count_items += $quote['quantity'];
            $subtotal += $quote['subtotal'];
        }

        return [
            'basket_ulid' => $this->basketModel->id,
            'count_products' => $count_products,
            'count_items' => $count_items,
            'total' => $subtotal,
            'created_at' => $this->basketModel->created_at,
            'updated_at' => $this->basketModel->updated_at,
            'quotes' => $quotes,
        ];
    }

    public function getBasketUlid(): String
    {
        return $this->basketModel->id;
    }
}
