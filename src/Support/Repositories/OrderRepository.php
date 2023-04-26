<?php

namespace Basketin\Support\Repositories;

use Basketin\Models\Order;

class OrderRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Order;
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
