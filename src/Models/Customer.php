<?php

namespace OutMart\Laravel\Customers\Models;

use Illuminate\Database\Eloquent\Model;
use OutMart\Laravel\Customers\Contracts\AppendUserData;
use OutMart\Laravel\Customers\Contracts\WithAddresses;

class Customer extends Model
{
    public function __construct()
    {
        if ($this instanceof AppendUserData) {
            $this->with = ['customerable'];
            $this->appends = ['user_id', 'name', 'email'];
        }

        if ($this instanceof WithAddresses) {
            $this->with = ['customerable', 'addresses'];
        }
    }

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

    public function getUserIdAttribute()
    {
        if ($this instanceof AppendUserData) {
            return $this->customerable->id;
        }
    }

    public function getNameAttribute()
    {
        if ($this instanceof AppendUserData) {
            return $this->customerable->name;
        }
    }

    public function getEmailAttribute()
    {
        if ($this instanceof AppendUserData) {
            return $this->customerable->email;
        }
    }

    public function customerable()
    {
        return $this->morphTo();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
