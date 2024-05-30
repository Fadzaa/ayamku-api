<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() :JsonResponse
    {
        $orders = Order::all();

        return response()->json(
            [
                'data' => $orders,
            ]
        );
    }

    public function store(OrderRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $data['user_id'] = Cart::all()->where('id', $data['cart_id'])->first()->user_id;

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
