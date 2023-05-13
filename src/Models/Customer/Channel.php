<?php

namespace Basketin\Models\Customer;

use Illuminate\Database\Eloquent\SoftDeletes;
use Basketin\Base\ModelBase;

class Channel extends ModelBase
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customer_channels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function customers()
    {
        return $this->hasMany(CustomerChannel::class, 'channel_id', 'id');
    }
}
