<?php

namespace Store\Support\Repositories;

use Store\Models\Customer;

class CustomerRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Customer;
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
