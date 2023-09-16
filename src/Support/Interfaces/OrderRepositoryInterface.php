<?php

namespace Store\Support\Interfaces;

use Store\Models\Order;

interface OrderRepositoryInterface
{
    /**
     * Get order by id
     *
     * @param int $id
     *
     * @return \Store\Models\Order
     */
    public function getById($id) : Order;

    /**
     * Create new order
     *
     * @param array $data
     *
     * @return \Store\Models\Order
     */
    public function create($data) : Order;
}