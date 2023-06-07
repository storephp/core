<?php

namespace Store\Support\Repositories;

use Store\Models\Customer;
use Store\Support\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = new Customer;
    }

    /**
     * Get customer by id
     *
     * @param int $id
     *
     * @return \Store\Models\Customer
     */
    public function getById($id) : Customer
    {
        return $this->model->find($id);
    }

    /**
     * Create new customer
     *
     * @param array $data
     *
     * @return \Store\Models\Customer
     */
    public function create($data) : Customer
    {
        return $this->model->create($data);
    }
}