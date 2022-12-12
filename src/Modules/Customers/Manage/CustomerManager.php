<?php

namespace Bidaea\OutMart\Modules\Customers\Manage;

use Bidaea\OutMart\Customers\Models\Customer;

class CustomerManager
{
    private $customerModel;

    public function __construct()
    {
        $this->customerModel = config('outmart.customers.model', Customer::class)::query();
    }

    public function query()
    {
        return (clone $this->customerModel);
    }

    public function find($id)
    {
        return (clone $this->customerModel)->find($id);
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
