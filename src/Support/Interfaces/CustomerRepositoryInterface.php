<?php

namespace Store\Support\Interfaces;

use Store\Models\Customer;

interface CustomerRepositoryInterface
{
    /**
     * Get customer by id
     *
     * @param int $id
     *
     * @return \Store\Models\Customer
     */
    public function getById($id) : Customer;

    /**
     * Create new customer
     *
     * @param array $data
     *
     * @return \Store\Models\Customer
     */
    public function create($data) : Customer;
}