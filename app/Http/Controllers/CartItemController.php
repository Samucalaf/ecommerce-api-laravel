<?php

namespace App\Http\Controllers;

use App\Http\Requests\Carts\StoreCartItemRequest;
use App\Http\Requests\Carts\UpdateCartItemRequest;
use Illuminate\Http\Request;
use App\Services\CartItemService;
use App\Http\Resources\ProductInCartResource;


class CartItemController extends Controller
{
    protected $cartItemService;

    public function __construct(CartItemService $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function store(StoreCartItemRequest $request, $productId)
    {
        $userId = $request->user()->id;
        $quantity = $request->input('quantity', 1);

        try {
            $item = $this->cartItemService->addProductToCart($userId, $productId, $quantity);
            return response()->json([
                'message' => 'Product added to cart successfully',
                'item' => new ProductInCartResource($item)
            ], 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(UpdateCartItemRequest $request, $productId)
    {
        $userId = $request->user()->id;
        $quantity = $request->input('quantity');

        try {
            $item = $this->cartItemService->updateProductInCart($userId, $productId, $quantity);
            return response()->json([
                'message' => 'Cart item updated successfully',
                'item' => new ProductInCartResource($item)
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Request $request, $productId)
    {
        $userId = $request->user()->id;

        try {
            $item = $this->cartItemService->removeProductFromCart($userId, $productId);
            return response()->json([
                'message' => 'Product removed from cart successfully',
                'item' => new ProductInCartResource($item)
            ], 200);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
