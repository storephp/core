<?php

namespace Basketin\Models\Order;

use Basketin\Base\ModelBase;

class Address extends ModelBase
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'label',
        'first_name',
        'last_name',
        'street_line_1',
        'street_line_2',
        'country',
        'city',
        'state',
        'postcode',
        'contact_email',
        'contact_phone',
    ];
}
