<?php

namespace OutMart\Laravel\Customers\Models;

use Illuminate\Database\Eloquent\Model;
// use OutMart\Laravel\Customers\Traits\WithAddresses;
// use OutMart\Laravel\Customers\Traits\WithUserData;

class Customer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outmart_customers';

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
}
