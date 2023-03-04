<?php

namespace OutMart\Models\Order;

use OutMart\Base\ModelBase;

class Status extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'state_id',
        'status_key',
        'status_label',
    ];

    public function state() {
        return $this->hasOne(Status::class, 'id', 'state_id');
    }
}
