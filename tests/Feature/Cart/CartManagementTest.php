<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\CartItemRepository;
use App\Services\CartService;
use App\Repositories\CartRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\CartItemService;

class CartManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private CartService $cartService;
    private CartRepository $cartRepository;
    private CartItemService $cartItemService;

    private CartItemRepository $cartItemRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();


        $this->cartRepository = new CartRepository(new Cart());
        $this->cartService = new CartService($this->cartRepository);

        $this->cartItemRepository = new CartItemRepository(new Cart());
        $this->cartItemService = new CartItemService($this->cartItemRepository);
    }



    public function test_limpar_carrinho()
    {
        $cart = Cart::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'active'
        ]);


        $product = Product::factory()->create();
        CartItem::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $result = $this->cartService->clearUserCart($this->user->id);

        $this->assertTrue($result);

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id
        ]);
    }


    public function test_adiconar_produto_ao_carrinho(){

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'stock' => 50
        ]);
        $quantity = 1;

        $cartItem = $this->cartItemService->addProductToCart($user->id, $product->id, $quantity);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cartItem->cart_id,
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);


    }


    public function test_atulizar_quantidade_produto_no_carrinho(){

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'stock' => 50
        ]);
        $initialQuantity = 1;

        $cartItem = $this->cartItemService->addProductToCart($user->id, $product->id, $initialQuantity);

        $newQuantity = 10;
        $updatedCartItem = $this->cartItemService->updateProductInCart($user->id, $product->id, $newQuantity);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $updatedCartItem->cart_id,
            'product_id' => $product->id,
            'quantity' => $newQuantity
        ]);
    }

    public function test_remover_um_produto_do_carrinho(){

        $user = User::factory()->create();
        $product = Product::factory()->create([
            'stock' => 50
        ]);
        $quantity = 4;

        $cartItem = $this->cartItemService->addProductToCart($user->id, $product->id, $quantity);

        $removedCartItem = $this->cartItemService->removeProductFromCart($user->id, $product->id);

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $removedCartItem->cart_id,
            'product_id' => $product->id
        ]);
    }


}
