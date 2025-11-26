<?php


namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Repositories\OrderRepository;

class OrderService
{


    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    public function listUserOrders($userId)
    {
        return $this->orderRepository->listOrders($userId);
    }


    public function createUserOrder(Cart $cart, int $addressId)
    {
        if (!$addressId) {
            throw new \InvalidArgumentException('Address ID is required to create an order.');
        }

        if ($cart == null){
            throw new \InvalidArgumentException('Cart not found for the user.');
        }

        if ($addressId == null){
            throw new \InvalidArgumentException('Address ID is invalid.');
        }

        if ($cart->items->isEmpty() || $cart->items->count() === 0) {
            throw new \InvalidArgumentException('Cart is empty. Cannot create order.');
        }


        return $this->orderRepository->createOrder($cart, $addressId);
    }


    public function getUserOrderById($userId, $id)
    {
        return $this->orderRepository->findOrderById($userId, $id);
    }


    public function updateUserOrderStatus(Order $order, string $status)
    {
        if ($status !== 'pending' && $status !== 'paid' && $status !== 'shipped' && $status !== 'delivered' && $status !== 'cancelled') {
            throw new \InvalidArgumentException('Invalid status value.');
        }

        return $this->orderRepository->updateOrderStatus($order, $status);
    }
}
