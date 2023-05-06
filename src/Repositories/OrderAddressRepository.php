<?php

namespace Store\Repositories;

use Store\Models\Order\Address;

class OrderAddressRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Address;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
