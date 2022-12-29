<?php

namespace OutMart\Models;

use Exception;
use Illuminate\Support\Str;
use OutMart\Base\ModelBase;
use OutMart\DataType\ProductSku;
use OutMart\Enums\Baskets\Status;
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

    public static function boot()
    {
        parent::boot();

        static::updating(function (Basket $basket) {
            if (!$basket->status instanceof Status) {
                throw new Exception("You must use `\OutMart\Enums\Baskets\Status` for select status");
            }
        });
    }

    public function initBasket(string $basket_ulid = null, string $currency = 'USD')
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

    public function canPlaceOrder()
    {
        return $this->quotes()->exists() && in_array($this->status, [Status::OPENED(), Status::ABANDONED()]);
    }
}
