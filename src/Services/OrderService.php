<?php

namespace OutMart\Services;

use Exception;
use OutMart\Enums\Baskets\Status;
use OutMart\Repositories\OrderAddressRepository;
use OutMart\Repositories\OrderRepository;

class OrderService
{
    private $order;

    public function __construct(
        private OrderRepository $orderRepository,
        private OrderAddressRepository $orderAddressRepository,
    ) {}

    public function placeOrder(BasketService $basket, CustomerService $customer)
    {
        if (!$basket->canPlaceOrder()) {
            throw new Exception("can't place this order");
        }

        $orderData = $basket->prefaceOrder();

        $orderData['customer_id'] = $customer->getData('id');
        $orderData['basket_id'] = $basket->prefaceOrder('basket')->id;

        $order = $this->orderRepository->create($orderData);
        $basket->prefaceOrder('basket')->status = Status::ORDERED();
        $basket->prefaceOrder('basket')->save();
        $this->order = $order;

        return $this;
    }

    public function assignAddress(
        string $label,
        string $first_name,
        string $last_name,
        string $street_line_1,
        string $country,
        string $city,
        string $state,
        string $contact_phone,
        string $postcode = null,
        string $contact_email = null,
        string $street_line_2 = null,
    ) {
        $address = [
            'order_id' => $this->order->id,
            'label' => $label,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'street_line_1' => $street_line_1,
            'street_line_2' => $street_line_2,
            'country' => $country,
            'city' => $city,
            'state' => $state,
            'postcode' => $postcode,
            'contact_email' => $contact_email,
            'contact_phone' => $contact_phone,
        ];

        return $this->orderAddressRepository->create($address);
    }

    /**
     * Get the order
     */
    public function getOrder()
    {
        return $this->order;
    }

    public function revert($id)
    {
        $order = $this->orderRepository->getById($id);

        if ($order) {
            $order->basket->status = Status::OPENED();
            $order->basket->save();
        }
    }
}
