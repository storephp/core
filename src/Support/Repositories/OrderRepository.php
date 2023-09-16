<?php

namespace Store\Support\Repositories;

use Store\Models\Order;
use Store\Support\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new Order;
    }

    /**
     * Get order by id
     *
     * @param int $id
     *
     * @return \Store\Models\Order
     */
    public function getById($id) : Order
    {
        return $this->model->find($id);
    }

    /**
     * Create new order
     *
     * @param array $data
     *
     * @return \Store\Models\Order
     */
    public function create($data) : Order
    {
        return $this->model->create($data);
    }
}