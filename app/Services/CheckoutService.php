<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Order;

class CheckoutService
{
    protected CustomerService $customerService;
    protected OrderService $orderService;
    protected PaymentService $paymentService;

    public function __construct(CustomerService $customerService, OrderService $orderService, PaymentService $paymentService)
    {
        $this->customerService = $customerService;
        $this->orderService = $orderService;
        $this->paymentService = $paymentService;
    }

    public function processCheckout(array $data): Order
    {
        $customer = $this->customerService->findOrCreate(
            [
                'name' => $data['name'],
                'document' => $data['document'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]
        );


        $order = $this->orderService->create([
            'customer_id' => $customer->id,
            'total' => $data['product']['price'],
            'status' => PaymentStatus::PENDING,
            'payment_method' => $data['payment-method'],
            'order_items' => [
                [
                    'product_id' => $data['product']['id'],
                    'quantity' => 1,
                    'price' => $data['product']['price'],
                ],
            ],
        ]);


        $payment = $this->paymentService->create([
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'payment_method' => $order->payment_method,
            'amount' => $order->total,
            'status' => PaymentStatus::PENDING,
        ]);




        $this->paymentService->processPayment($da);

        return $order;
    }


}
