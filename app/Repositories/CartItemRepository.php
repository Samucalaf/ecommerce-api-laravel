<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Product;

class CartItemRepository
{
    protected $cartModel;

    public function __construct(Cart $cart)
    {
        $this->cartModel = $cart;
    }

    public function postProductToCart($idUser, $productId, $quantity)
    {
        $product = Product::find($productId);
        $cart = Cart::findOrCreateActiveCart($idUser);


        $item = $cart->items()->updateOrCreate(
            ['product_id' => $productId],
            [
                'quantity' => $quantity,
                'price' => $product->price
            ]
        );

        return $item;
    }

    public function updateProduct($userId, $product, $quantity)
    {
        $cart = Cart::findOrCreateActiveCart($userId);

        if (!$cart) {
            return null;
        }


        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->quantity = $quantity;
            $item->save();
        }

        return $item;
    }

    public function removeProduct($userId, $product)
    {
        $cart = Cart::findOrCreateActiveCart($userId);

        if (!$cart) {
            return null;
        }

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->delete();
        }

        return $item;
    }
}
