<?php

namespace OutMart\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use OutMart\Base\ModelBase;
use OutMart\Models\Order\State;
use OutMart\Models\Order\Status;

class Order extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'basket_id',
        'status_id',
        'discount_details',
        'sub_total',
        'discount_total',
        'shipping_total',
        'tax_total',
        'grand_total',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'discount_details' => 'array',
    ];

    /**
     * Scope a query to only include popular users.
     */
    public function scopeHasState(Builder $query, string | array $state): void
    {
        if (is_string($state)) {
            $state = State::where('state_key', $state)->first('id');

            if (!$state) {
                throw new Exception("State not found");
            }

            $statuses_id = Status::where('state_id', $state->id)->pluck('id');
            $query->whereIn('status_id', $statuses_id);
        }

        if (is_array($state)) {
            $statesIds = State::whereIn('state_key', $state)->pluck('id');
            $statuses_id = Status::whereIn('state_id', $statesIds)->pluck('id');
            $query->whereIn('status_id', $statuses_id);
        }
    }

    /**
     * Scope a query to only include popular users.
     */
    public function scopeHasStatus(Builder $query, string | array $status): void
    {
        $typeState = gettype($state);

        if ($typeState == 'string') {
            $statuses_id = Status::where('status_key', $status)->pluck('id');
            $query->whereIn('status_id', $statuses_id);
        }

        if ($typeState == 'array') {
            $statuses_id = Status::whereIn('status_key', $status)->pluck('id');
            $query->whereIn('status_id', $statuses_id);
        }
    }

    public function customer()
    {
        return $this->hasOne(config('outmart.customers.model'), 'id', 'customer_id');
    }

    public function basket()
    {
        return $this->hasOne(Basket::class, 'id', 'basket_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }
}
