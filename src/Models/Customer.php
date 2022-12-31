<?php

namespace OutMart\Models;

use OutMart\Base\ModelBase;
use OutMart\Models\Customer\CustomerChannel;

class Customer extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    // protected $dispatchesEvents = [
    //     'created' => CustomerCreated::class,
    // ];

    public function channels()
    {
        return $this->hasMany(CustomerChannel::class, 'customer_id', 'id');
    }
}
