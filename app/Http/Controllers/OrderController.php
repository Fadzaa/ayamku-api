<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index() :JsonResponse
    {
        $orders = Order::all()->load(['user', 'cart.cartItems', 'post']);

        return response()->json(
            [
                'data' => OrderResource::collection($orders),
            ]
        );
    }

    public function show() : JsonResponse
    {
        $userId = Auth::id();

        $orders = Order::all()->where('user_id', $userId)->load(['user', 'cart.cartItems', 'post'])->first();

        return response()->json(
            [
                'data' => new OrderResource($orders),
            ]
        );
    }

    public function store(OrderRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $userId = Auth::id();

        $data['user_id'] = $userId;

        $order = new Order();
        $order->fill($data);
        $order->save();

        return response()->json(
            [
                'message' => 'Order created successfully',
                'data' => $order,
            ],
            201
        );
    }
}
