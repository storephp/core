<?php

namespace OutMart\Repositories;

use OutMart\Models\Customer;

class CustomerRepository
{
    private $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
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
