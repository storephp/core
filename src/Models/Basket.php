<?php

namespace Basketin\Models;

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
