<?php

namespace Bidaea\OutMart\Modules\Baskets\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outmart_baskets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ulid',
        'currency',
        'status',
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'basket_id', 'id');
    }
}
