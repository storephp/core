<?php

namespace OutMart\Laravel\Customers\Manage;

class Customers
{
    private $customerModel;

    public function __construct()
    {
        $this->customerModel = config('outmart.customers.model');
    }

    public function load()
    {
        return $this->customerModel::with(['customerable', 'addresses']);
    }

    public function find($customer_id)
    {
        return $this->customerModel::with(['customerable', 'addresses'])
            ->find($customer_id);
    }

    // public function listingCollection($customers)
    // {
    //     $collection = collect($customers);

    //     $customers = $collection->map(function ($customer) {
    //         return [
    //             'name' => $customer->customerable->name,
    //             'email' => $customer->customerable->email,
    //             'metadata' => $customer->metadata,
    //             'addresses' => $customer->addresses,
    //         ];
    //     });

    //     return $customers->all();
    // }

    // public function getCollection($method, ...$args)
    // {
    //     $data = $this->{$method}($args);

    //     return match ($method) {
    //         'listing' => $this->listingCollection($data),
    //     };
    // }
}
