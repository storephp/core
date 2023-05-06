<?php

namespace Store\Support\Services;

use Store\Support\Repositories\CustomerRepository;

class CustomerService
{
    public $customer = null;

    public function __construct(
        private CustomerRepository $customerRepository,
    ) {}

    public function setCustomerId($customerId)
    {
        $this->customer = $this->customerRepository->getById($customerId);

        return $this;
    }

    public function getData($key = null)
    {
        return ($key) ? $this->customer->{$key} : $this->customer;
    }
}
