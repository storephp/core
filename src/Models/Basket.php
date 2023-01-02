<?php

namespace OutMart\Models;

use Exception;
use Illuminate\Support\Str;
use OutMart\Base\ModelBase;
use OutMart\Contracts\ICondition;
use OutMart\DataType\ProductSku;
use OutMart\Enums\Baskets\Status;
use OutMart\Events\Basket\BasketCreated;
use OutMart\Events\Basket\BasketCreating;
use OutMart\Events\Basket\BasketUpdated;
use OutMart\Events\Basket\BasketUpdating;
use OutMart\Models\Basket\Coupon;
use OutMart\Models\Basket\Quote;
use OutMart\PricingRules\Lay;

class Basket extends ModelBase
{
    public $shippingMethod = null;
    public $paymentMethod = null;

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

    public function applyCoupon($coupon)
    {
        if ($coupon = Coupon::where('coupon_code', $coupon)->first()) {
            $this->coupon_code = $coupon->coupon_code;
            $this->save();
        }

        return $this;
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'coupon_code', 'coupon_code');
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

    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getSubTotal(): float
    {
        $quotes = $this->quotes()->with('product')->get();

        $total = 0;

        if ($quotes) {
            foreach ($quotes as $quote) {
                $total += $quote->quantity * $quote->product?->final_price;
            }
        }

        return $total;
    }

    public function getTotal(): float
    {
        if (!$getSubTotal = $this->getSubTotal())
            return 0;

        $lay = new Lay;

        $lay->setTotal($getSubTotal);

        if ($getShippingMethod = $this->getShippingMethod())
            $lay->setShippingMethod($getShippingMethod);

        if ($getPaymentMethod = $this->getPaymentMethod())
            $lay->setPaymentMethod($getPaymentMethod);

        // Handle coupon
        if (($coupon = $this->coupon) && (!$this->coupon->expired))
            $lay->rule(function ($attributes) use ($coupon) {

                // 
                if ($coupon->condition) {
                    $conditionObj = config('outmart.coupons.conditions.' . $coupon->condition, null);
                    if ($conditionObj) {
                        $condition = new $conditionObj(
                            $attributes['total'],
                            $this->quotes()->pluck('product_sku')->toArray(),
                            $coupon->condition_data,
                        );

                        if (!$condition instanceof ICondition) {
                            throw new Exception('You need to implement `ICondition` in condition class');
                        }

                        return $condition->handle();
                    }
                    return false;
                }

                return true;
            }, function ($operations) use ($coupon) {
                $total = $operations->getTotal();

                if ($coupon->discount_type == 'percentage') {
                    $discount = ($total * $coupon->discount_value) / 100;
                    $total = $total - $discount;
                }

                if ($coupon->discount_type == 'fixed')
                    $total = $total - $coupon->discount_value;

                $operations->setTotal($total);
            });

        return $lay->getTotal();
    }

    public function placeOrder()
    {
        if (!$this->canPlaceOrder()) {
            throw new Exception("You cannot place an order from this basket");
        }

        return $this->getTotal();
    }
}
