<?php

namespace OutMart\Models;

use Illuminate\Support\Str;
use OutMart\Base\ModelBase;
use OutMart\DataType\ProductSku;
use OutMart\Enums\Baskets\Status;
use OutMart\Events\Basket\BasketCreated;
use OutMart\Events\Basket\BasketCreating;
use OutMart\Events\Basket\BasketUpdated;
use OutMart\Events\Basket\BasketUpdating;
use OutMart\Models\Basket\Quote;

class Basket extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'baskets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ulid',
        'currency',
        'status',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => BasketCreating::class,
        'created' => BasketCreated::class,
        'updating' => BasketUpdating::class,
        'updated' => BasketUpdated::class,
    ];

    public static function initBasket(string $basket_ulid = null, string $currency = 'USD')
    {
        $basket = parent::whereUlid($basket_ulid)
            ->whereIn('status', [Status::OPENED(), Status::ABANDONED()])
            ->first();

        if (!$basket) {
            $basket = static::create([
                'ulid' => $basket_ulid ?? (string) Str::ulid(),
                'currency' => $currency,
            ]);
        }

        return $basket;
    }

    public function addQuotes(ProductSku $productSku, int $quantity = 1)
    {
        $quote = $this->quotes()->where('basket_id', $this->id)
            ->where('product_sku', $productSku)
            ->first();

        if ($quote) {
            return $quote->increase($quantity);
        }

        return $this->quotes()->create([
            'product_sku' => $productSku,
            'quantity' => $quantity,
        ]);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'basket_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'basket_id', 'id');
    }

    public function canUpdateStatus()
    {
        return in_array($this->status, [Status::OPENED(), Status::ABANDONED()]);
    }

    public function canPlaceOrder()
    {
        return $this->quotes()->exists() && in_array($this->status, [Status::OPENED(), Status::ABANDONED()]);
    }

    public function placeOrder()
    {
        if (!$this->canPlaceOrder()) {
            throw new Exception("Count't place order from this basket");
        }

        // $sub_total = $this->quotes()->with('product')->get()->map(function ($quote) {
        //     return ($quote->quantity * $quote->product?->final_price) ?? 0;
        // });

        // return $sub_total;

        // return array_sum($sub_total);

        $quotes = $this->quotes()->with('product')->get();


        $total = 0;

        foreach ($quotes as $quote) {
            $total += $quote->quantity * $quote->product?->final_price;
        }

        return $total;
    }
}
