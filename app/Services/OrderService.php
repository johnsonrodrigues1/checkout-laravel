<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;

class OrderService
{
    protected OrderRepository $orderRepository;
    protected OrderItemRepository $orderItemRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository)
    {
        $this->orderItemRepository = $orderItemRepository;
        $this->orderRepository = $orderRepository;
    }

    public function create(array $data): Order
    {
        $order = $this->orderRepository->create([
            'customer_id' => $data['customer_id'],
            'total' => $data['total'],
            'status' => $data['status'],
            'payment_method' => $data['payment_method'],
        ]);

        foreach ($data['order_items'] as $orderItem) {
            $this->orderItemRepository->create([
                'order_id' => $order->id,
                'product_id' => $orderItem['product_id'],
                'quantity' => $orderItem['quantity'],
                'price' => $orderItem['price']
            ]);
        }

        return $order;
    }
}
