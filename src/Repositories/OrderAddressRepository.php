<?php

namespace OutMart\Repositories;

use OutMart\Models\Order\Address;

class OrderAddressRepository
{
    private $model;

    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
