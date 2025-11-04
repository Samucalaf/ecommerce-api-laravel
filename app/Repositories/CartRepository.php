<?php

namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{

    protected $model;

    public function __construct(Cart $cart)
    {
        $this->model = $cart;
    }

    /**
     * Retrieve the cart for a specific user along with its products and calculate the total.
     *
     * @param int $idUser The ID of the user whose cart is to be retrieved.
     * @return mixed The cart with calculated total, or null if not found.
     */
    public function getCartByUserId($idUser)
    {
        $cart = $this->model->with('items.product')->where('user_id', $idUser)->first();

        if ($cart) {
            $cart->calculateTotal = $cart->calculateTotal();
            return $cart;
        }

        return null;
    }


    public function clearCart($userId)
    {
        $cart = $this->model->where('user_id', $userId)->first();
        if ($cart) {
            $cart->items()->delete();
        }
        return true;
    }

}
