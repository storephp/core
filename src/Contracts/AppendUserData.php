<?php

namespace OutMart\Laravel\Customers\Contracts;

interface AppendUserData
{
    public function getUserIdAttribute();

    public function getNameAttribute();

    public function getEmailAttribute();
}
