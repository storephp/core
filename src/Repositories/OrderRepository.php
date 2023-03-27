<?php

namespace OutMart\Repositories;

use OutMart\Models\Order;

class OrderRepository
{
    private $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
