<?php

namespace Store\Models;

use Store\Base\ModelBase;
use Store\Events\Basket\BasketCreated;
use Store\Events\Basket\BasketCreating;
use Store\Events\Basket\BasketUpdated;
use Store\Events\Basket\BasketUpdating;
use Store\Models\Basket\Coupon;
use Store\Models\Basket\Quote;

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
}
