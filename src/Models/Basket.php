<?php

namespace Basketin\Models;

use Illuminate\Support\Str;
use Basketin\Base\ModelBase;
use Basketin\Events\Basket\BasketCreated;
use Basketin\Events\Basket\BasketCreating;
use Basketin\Events\Basket\BasketUpdated;
use Basketin\Events\Basket\BasketUpdating;
use Basketin\Models\Basket\Coupon;
use Basketin\Models\Basket\Quote;

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

    // public static function initBasket(string $basket_ulid = null, string $currency = 'USD')
    // {
    //     if (parent::whereUlid($basket_ulid)->where('status', Status::ORDERED())->exists()) {
    //         throw new Exception("The ULID for this basket already exists");
    //     }

    //     $basket = parent::whereUlid($basket_ulid)
    //         ->whereIn('status', [Status::OPENED(), Status::ABANDONED()])
    //         ->first();

    //     if (!$basket) {
    //         $basket = static::create([
    //             'ulid' => $basket_ulid ?? (string) Str::ulid(),
    //             'currency' => $currency,
    //         ]);
    //     }

    //     return $basket;
    // }

    // public function addQuotes(ProductSku $productSku, int $quantity = 1)
    // {
    //     $quote = $this->quotes()->where('basket_id', $this->id)
    //         ->where('product_sku', $productSku)
    //         ->first();

    //     if ($quote) {
    //         return $quote->increase($quantity);
    //     }

    //     $quote = $this->quotes()->create([
    //         'product_sku' => $productSku,
    //         'quantity' => $quantity,
    //     ]);

    //     return $quote;
    // }

    // public function applyCoupon($coupon)
    // {
    //     if ($coupon = Coupon::where('coupon_code', $coupon)->first()) {
    //         $this->coupon_code = $coupon->coupon_code;
    //         $this->save();
    //     }

    //     return $this;
    // }

    // public function resetCoupon()
    // {
    //     if ($this->coupon_code) {
    //         $this->coupon_code = null;
    //         $this->save();
    //     }

    //     return $this;
    // }

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'coupon_code', 'coupon_code');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'basket_id', 'id');
    }

    public function quote()
    {
        return $this->hasOne(Quote::class, 'basket_id', 'id');
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'basket_id', 'id');
    }

    public function customer()
    {
        return $this->morphTo();
    }

    // public function canUpdateStatus()
    // {
    //     return in_array($this->status, [Status::OPENED(), Status::ABANDONED()]);
    // }

    // public function canPlaceOrder()
    // {
    //     return $this->quotes()->exists() && in_array($this->status, [Status::OPENED(), Status::ABANDONED()]);
    // }

    // public function getShippingMethod()
    // {
    //     return $this->shippingMethod;
    // }

    // public function setShippingMethod($shippingMethod)
    // {
    //     $this->shippingMethod = $shippingMethod;

    //     return $this;
    // }

    // public function getPaymentMethod()
    // {
    //     return $this->paymentMethod;
    // }

    // public function setPaymentMethod($paymentMethod)
    // {
    //     $this->paymentMethod = $paymentMethod;

    //     return $this;
    // }

    // public function getDiscountTotal(): float
    // {
    //     return $this->getTotal() - $this->getSubTotal();
    // }

    // public function getSubTotal(): float
    // {
    //     $quotes = $this->quotes()->with('product')->get();

    //     $total = 0;

    //     if ($quotes) {
    //         foreach ($quotes as $quote) {
    //             if (!$quote->product instanceof IFinalPrice) {
    //                 throw new Exception("You must implement `\Basketin\Contracts\Model\IFinalPrice`");
    //             }

    //             $total += $quote->quantity * $quote->product?->final_price;
    //         }
    //     }

    //     return $total;
    // }

    // public function getTotal(): float
    // {
    //     if (!$getSubTotal = $this->getSubTotal())
    //         return 0;

    //     $lay = new Lay;

    //     $lay->setTotal($getSubTotal);

    //     if ($getShippingMethod = $this->getShippingMethod())
    //         $lay->setShippingMethod($getShippingMethod);

    //     if ($getPaymentMethod = $this->getPaymentMethod())
    //         $lay->setPaymentMethod($getPaymentMethod);

    //     // Handle coupon
    //     if (($coupon = $this->coupon) && (!$this->coupon->expired))
    //         $lay->rule(function ($attributes) use ($coupon) {

    //             //
    //             if ($coupon->condition) {
    //                 $conditionObj = config('basketin.coupons.conditions.' . $coupon->condition, null);
    //                 if ($conditionObj) {
    //                     $condition = new $conditionObj(
    //                         $attributes['total'],
    //                         $this->quotes()->pluck('product_sku')->toArray(),
    //                         $coupon->condition_data,
    //                     );

    //                     if (!$condition instanceof ICondition) {
    //                         throw new Exception('You need to implement `ICondition` in condition class');
    //                     }

    //                     return $condition->handle();
    //                 }
    //                 return false;
    //             }

    //             return true;
    //         }, function ($operations) use ($coupon) {
    //             $total = $operations->getTotal();

    //             if ($coupon->discount_type == 'percentage') {
    //                 $discount = ($total * $coupon->discount_value) / 100;
    //                 $total = $total - $discount;
    //             }

    //             if ($coupon->discount_type == 'fixed')
    //                 $total = $total - $coupon->discount_value;

    //             $operations->setTotal($total);
    //         });

    //     return $lay->getTotal();
    // }

    // public function placeOrder($address_id)
    // {
    //     if (!$this->canPlaceOrder()) {
    //         throw new Exception("You cannot place an order from this basket");
    //     }

    //     $orderData = [];

    //     $orderData['customer_id'] = $this->customer->id;
    //     // $orderData['status_id'] = 1;

    //     if (($coupon = $this->coupon) && (!$this->coupon->expired)) {
    //         $orderData['discount_details'] = [
    //             'discount_type' => 'coupon',
    //             'coupon' => [
    //                 'coupon_code' => $coupon->coupon_code,
    //                 'discount_value' => $coupon->discount_value,
    //                 'discount_value' => $coupon->discount_value,
    //                 'condition' => $coupon->condition,
    //                 'condition_data' => $coupon->condition_data,
    //                 'start_at' => $coupon->start_at,
    //                 'ends_at' => $coupon->ends_at,
    //             ],
    //         ];

    //         $orderData['discount_total'] = $this->getDiscountTotal();
    //     }

    //     $orderData['sub_total'] = $this->getSubTotal();
    //     $orderData['shipping_total'] = 0;
    //     $orderData['tax_total'] = 0;
    //     $orderData['grand_total'] = $this->getTotal();

    //     if ($this->order()->exists()) {
    //         throw new Exception("Already there is an order for this basket");
    //     }

    //     $address = $this->customer->addresses()->find($address_id);

    //     if (!$address) {
    //         throw new Exception("Error Processing Request");
    //     }

    //     $order = $this->order()->create($orderData);

    //     if ($this->canUpdateStatus()) {
    //         $this->status = Status::ORDERED();
    //         $this->save();
    //     }

    //     Address::create([
    //         'order_id' => $order->id,
    //         'title' => $address->label,
    //         'first_name' => $this->customer->first_name,
    //         'last_name' => $this->customer->last_name,
    //         'street_line_1' => $address->street_line_1,
    //         'street_line_2' => $address->street_line_2,
    //         'country' => null,
    //         'city' => null,
    //         'state' => null,
    //         'postcode' => $address->postcode,
    //         'contact_email' => $this->customer->email,
    //         'contact_phone' => $address->telephone_number,
    //     ]);

    //     return $order;
    // }
}
