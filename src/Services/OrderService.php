<?php

namespace OutMart\Services;

use Exception;
use OutMart\Enums\Baskets\Status;
use OutMart\Models\Order\Status as OrderStatus;
use OutMart\Repositories\OrderAddressRepository;
use OutMart\Repositories\OrderRepository;

class OrderService
{
    private $orderData;
    private $orderDataCreated;

    public function __construct(
        private OrderRepository $orderRepository,
        private OrderAddressRepository $orderAddressRepository,
    ) {}

    public function initOrder(BasketService $basket, CustomerService $customer)
    {
        if (!$basket->canPlaceOrder()) {
            throw new Exception("can't place this order");
        }

        $orderData = $basket->prefaceOrder();

        if (($coupon = $basket->getCoupon()) && (!$basket->getCoupon()->expired)) {
            $orderData['discount_details'] = [
                'discount_type' => 'coupon',
                'coupon' => [
                    'coupon_code' => $coupon->coupon_code,
                    'discount_value' => $coupon->discount_value,
                    'discount_value' => $coupon->discount_value,
                    'condition' => $coupon->condition,
                    'condition_data' => $coupon->condition_data,
                    'start_at' => $coupon->start_at,
                    'ends_at' => $coupon->ends_at,
                ],
            ];

            $orderData['discount_total'] = $basket->getDiscountTotal();
        }

        $orderData['customer_id'] = $customer->getData('id');
        $orderData['basket_id'] = $basket->prefaceOrder('basket')->id;

        $this->basket = $basket;
        $this->orderData = $orderData;

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
            'order_id' => $this->orderData->id,
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

    public function placeOrder()
    {
        $this->orderDataCreated = $this->orderRepository->create($this->orderData);
        $this->basket->prefaceOrder('basket')->status = Status::ORDERED();
        $this->basket->prefaceOrder('basket')->save();

        return $this;
    }

    /**
     * Get the order
     */
    public function getOrder()
    {
        return $this->orderDataCreated;
    }

    public function revert($id)
    {
        $order = $this->orderRepository->getById($id);

        if ($order) {
            $order->basket->status = Status::OPENED();
            $order->basket->save();
        }
    }

    public function updateStatus($statusKey)
    {
        $status = OrderStatus::where('status_key', $statusKey)->first();

        if ($status) {
            $this->orderDataCreated->status_id = $status->id;
            $this->orderDataCreated->save();
        }
    }
}
