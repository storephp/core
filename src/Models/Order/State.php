<?php

namespace Store\Models\Order;

use Store\Base\ModelBase;

class State extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'state_key',
        'state_label',
    ];

    public function status() {
        return $this->hasOne(Status::class, 'state_id', 'id');
    }
}
