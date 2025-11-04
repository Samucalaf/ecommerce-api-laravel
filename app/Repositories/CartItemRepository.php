<?php

namespace App\Repositories;

use App\Models\CartItem;

class CartItemRepository
{

    protected $model;
    public function __construct(CartItem $cartItem)
    {
        $this->model = $cartItem;
    }

    public function postProductToCart($idUser, $productId, $quantity)
    {
        $cart = $this->model->firstOrCreate(
            ['user_id' => $idUser],
        );

        $item = $cart->items()->updateOrCreate(
            ['product_id' => $productId],
            ['quantity' => $quantity]
        );
        $cart->load('items.product');
        $cart->calculateTotal = $cart->calculateTotal();
        return $item;
    }

    public function updateProduct($userId, $productId, $quantity)
    {
        $item = $this->model->items()->where('product_id', $productId)->first();
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
        }
        return $item;
    }

    public function removeProduct($userId, $productId)
    {

        $item = $this->model->items()->where('product_id', $productId)->first();
        if ($item) {
            $item->delete();
        }
        return $item;
    }
    
}
