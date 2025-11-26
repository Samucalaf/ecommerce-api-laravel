<?php


namespace App\Repositories;

use App\Models\Order;
use App\Models\Cart;
use App\Events\OrderCreated;
use App\Models\Product;

class OrderRepository
{
    protected $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }



    public function listOrders($userId)
    {
        $orders = $this->model->forUser($userId)->with('items.product', 'address')->paginate(10);

        return $orders;
    }

    public function createOrder(Cart $cart, int $addressId)
    {
        $total = $cart->calculateTotal();
        $order_number = $this->model->generateUniqueOrderNumber();

        $order = $this->model->create([
            'user_id' => $cart->user_id,
            'address_id' => $addressId,
            'total' => $total,
            'status' => 'pending',
            'order_number' => $order_number,
        ]);

        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }



        event(new OrderCreated($order, $cart));

        $cart->items()->delete();

        return $order;
    }

    public function findOrderById($userId, $id)
    {
        return $this->model->forUser($userId)->with('items')->find($id);
    }

    public function updateOrderStatus(Order $order, string $status)
    {
        $order->update(['status' => $status]);
        return $order;
    }
}
