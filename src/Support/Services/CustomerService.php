<?php

namespace Store\Support\Services;

use Store\Support\Interfaces\CustomerRepositoryInterface;

class CustomerService
{
    public $customer = null;

    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
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
