<?php

namespace Store\Support\Services;

use Illuminate\Support\Facades\Auth;
use Store\Support\Repositories\CustomerRepository;

class CustomerService
{
    public $customer = null;

    public function __construct(
        private CustomerRepository $customerRepository,
    ) {
    }

    public function create($data)
    {
        return $this->customerRepository->create($data);
    }

    public function attempt(array $credentials = [], $remember = false)
    {
        $attempt = Auth::guard('customer')->attempt($credentials, $remember);

        if ($attempt) {
            return Auth::guard('customer')->user();
        }

        return false;
    }

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
