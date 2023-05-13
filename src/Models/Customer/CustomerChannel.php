<?php

namespace Store\Models\Customer;

use Store\Base\ModelBase;

class CustomerChannel extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_customer_channels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'channel_id',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [
        'channel',
    ];

    public function channel()
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }
}
