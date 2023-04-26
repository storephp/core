<?php

namespace Basketin\Support\Repositories;

use Basketin\Models\Customer;

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
