<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateStatusOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCompleteResource;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\OrderService;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);
        $userId = $request->user()->id;
        $order = $this->orderService->listUserOrders($userId);

        return response()->json(new OrderResource($order), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $this->authorize('create', Order::class);
        $user = $request->user();


        $cart = Cart::where('user_id', $user->id)->with('items')->first();
        $addressId = $request->validated()['address_id'];

        $order = $this->orderService->createUserOrder($cart, $addressId);

        return response()->json(new OrderCompleteResource($order), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $userId = $request->user()->id;
        $order = $this->orderService->getUserOrderById($userId, $id);

        $this->authorize('view', $order);

        return response()->json(new OrderCompleteResource($order), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStatusOrderRequest $request, Order $order)
    {
        $this->authorize('update', $order);
        $status = $request->validated()['status'];

        $updatedOrder = $this->orderService->updateUserOrderStatus($order, $status);
        return response()->json(new OrderResource($updatedOrder), 200);
    }
}
