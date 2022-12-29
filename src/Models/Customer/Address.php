<?php

namespace OutMart\Models\Customer;

use OutMart\Base\ModelBase;
use OutMart\Models\Customer;

class Address extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'label',
        'country_id',
        'city_id',
        'zip_code',
        'street_line_1',
        'street_line_2',
        'telephone_number',
        'is_main',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_main' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
