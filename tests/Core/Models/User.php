<?php

namespace Basketin\Tests\Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Basketin\Traits\User\IsCustomer;

class User extends Authenticatable
{
    use IsCustomer;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
