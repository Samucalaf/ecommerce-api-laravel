<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Seeder;
use App\Models\Product;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cart = Cart::create([
            'user_id' => 1,
        ]);

        $product1 = Product::find(1);
        $product2 = Product::find(2);

        
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => 1,
            'quantity' => 2,
            'price' => $product1->price,
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => 2,
            'quantity' => 1,
            'price' => $product2->price,
        ]);
    }
}
