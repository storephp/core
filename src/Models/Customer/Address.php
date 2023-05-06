<?php

namespace Store\Models\Customer;

use Store\Base\ModelBase;
use Store\Models\Customer;

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
        'country_code',
        'city_id',
        'postcode',
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
        'is_main' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
