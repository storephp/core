<?php

namespace Bidaea\OutMart\Modules\Baskets\Manage;

use Bidaea\OutMart\Modules\Baskets\Enums\Status;
use Bidaea\OutMart\Modules\Baskets\Models\Basket;
use Exception;
use Illuminate\Support\Str;

class BasketMethodManager
{
    private $basketModel;
    private $quote;

    public function __construct(string $basket_ulid = null, string $currency = 'USD', $customer = null)
    {
        if (!$basket_ulid) {
            $basket_ulid = (string) Str::ulid();
        }

        $basket = Basket::whereUlid($basket_ulid)
            ->whereIn('status', [Status::OPENED->value, Status::ABANDONED->value])
            ->first();

        if (!$basket) {
            $basket = Basket::create([
                'ulid' => $basket_ulid ?? (string) Str::ulid(),
                'currency' => $currency,
                'status' => Status::OPENED->value,
            ]);
        }

        if (
            $customer && $customer instanceof \App\Models\OutMart\Customer
            || $customer && $customer instanceof \Bidaea\OutMart\Modules\Customers\Models\Customer
        ) {
            $basket->customer_type = $customer::class;
            $basket->customer_id = $customer->id;
            $basket->save();
        }

        $this->basketModel = $basket;
    }

    public function addQuotes(int $product_sku, int $quantity = 1)
    {
        $item = $this->basketModel->quotes()->where('product_sku', $product_sku)->first();

        if (!$item) {
            $this->basketModel->quotes()->create([
                'product_sku' => $product_sku,
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

    public function quote($quote_id)
    {
        $this->quote = $this->quotes()->find($quote_id);
        return $this;
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

    public function updateStatus(Status $status)
    {
        $this->basketModel->status = $status->value;
        $this->basketModel->save();
        return $this;
    }

    public function getBasketUlid(): String
    {
        return $this->basketModel->ulid;
    }

    public function increase($quantity = 1)
    {
        if (!$this->quote) {
            throw new Exception('This quote is not found');
        }

        if ($this->quote->quantity >= config('outmart.baskets.max_quote')) {
            return 'ISMAXQUOTE';
        }

        return $this->quote->increment('quantity', $quantity);
    }

    public function decrease($quantity = 1)
    {
        if (!$this->quote) {
            throw new Exception('This quote is not found');
        }

        if ($this->quote->quantity > 1) {
            return $this->quote->decrement('quantity', $quantity);
        }

        return $this->quote->delete();
    }
}
