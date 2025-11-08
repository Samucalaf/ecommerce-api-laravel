<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use App\Services\CartService;
class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cart = $this->cartService->showCartUser($userId);
        return new CartResource($cart);
    }

    public function clear(Request $request)
    {
        $userId = $request->user()->id;
        $this->cartService->clearUserCart($userId);
        return response()->json(['message' => 'Cart cleared successfully.']);
    }
}
