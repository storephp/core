<?php

namespace OutMart\Models;

use OutMart\Baskets\Enums\Status;
use OutMart\Base\ModelBase;

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

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'basket_id', 'id');
    }

    public function canPlaceOrder()
    {
        return $this->quotes()->exists() && $this->whereIn('status', [Status::OPENED->value, Status::ABANDONED->value]);
    }
}
