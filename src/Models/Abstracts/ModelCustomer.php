<?php

namespace OutMart\Laravel\Customers\Models\Abstracts;

use Illuminate\Database\Eloquent\Model;
use OutMart\Laravel\Customers\Models\Address;

abstract class ModelCustomer extends Model
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
        'metadata' => 'json',
    ];

    public function customerable()
    {
        return $this->morphTo();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id', 'id');
    }
}
