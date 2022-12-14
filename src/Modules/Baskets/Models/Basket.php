<?php

namespace Bidaea\OutMart\Modules\Baskets\Models;

use Bidaea\OutMart\Modules\Baskets\Enums\Status;
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

    public function canOrdered()
    {
        if (
            $this->quotes->count() >= 1
            && $this->whereIn('status', [Status::opened->value, Status::abandoned->value])
        ) {
            return true;
        }

        return false;
    }
}
