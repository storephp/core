<?php

namespace OutMart\Models\Basket;

use OutMart\Base\ModelBase;

class Coupon extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'basket_coupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'discount_value',
        'start_at',
        'ends_at',
    ];

    // expired
    public function getExpiredAttribute()
    {
        return (!$this->start_at && !$this->ends_at) ? true : $this->active()->exists();
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('start_at', '>=', $now)
            ->orWhere('ends_at', '<=', $now);
    }
}
