<?php

namespace OutMart\Laravel\Customers\Traits;

trait WithUserData
{
    public function initializeWithUserData()
    {
        $this->with[] = 'customerable';

        array_push($this->appends, ...['user_id', 'name', 'email']);
    }

    public function getUserIdAttribute()
    {
        return $this->customerable->id;
    }

    public function getNameAttribute()
    {
        return $this->customerable->name;
    }

    public function getEmailAttribute()
    {
        return $this->customerable->email;
    }

    public function customerable()
    {
        return $this->morphTo();
    }
}
