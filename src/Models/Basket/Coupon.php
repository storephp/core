<?php

namespace Store\Models\Basket;

use Store\Base\ModelBase;

class Coupon extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'basket_coupons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'discount_type',
        'discount_value',
        'condition',
        'condition_data',
        'start_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'condition_data' => 'json',
    ];

    // expired
    public function getExpiredAttribute()
    {
        return (!$this->start_at && !$this->ends_at) ? false : !$this->active()->exists();
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $today = now()->format('Y-m-d');
        return $query->where('start_at', '<=', $today)
            ->where('ends_at', '>=', $today);
    }
}
