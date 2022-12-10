<?php

namespace OutMart\Laravel\Baskets\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasUlids;

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
        'currency',
        'status',
    ];

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'basket_id', 'id');
    }
}
