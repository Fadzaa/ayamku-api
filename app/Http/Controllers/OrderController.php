<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderStatusChangeRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index() :JsonResponse
    {
        $orders = Order::all();

        return response()->json(
            [
                'data' => OrderResource::collection($orders),
            ]
        );
    }

    public function show() : JsonResponse
    {
        $userId = Auth::id();

        $orders = Order::all()->where('user_id', $userId);

        if (!$orders) {
            return response()->json(
                [
                    'message' => 'This user has no order yet.',
                ],
                404
            );
        }

        return response()->json(
            [
                'data' => OrderResource::collection($orders),
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

        $order->status = 'processing';

        $order->save();

        return response()->json(
            [
                'message' => 'Order created successfully',
                'data' => $order,
            ],
            201
        );
    }

    public function updateStatus(OrderStatusChangeRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $order = Order::all()->where('id', $data['order_id'])->first();

        if (!$order) {
            return response()->json(
                [
                    'message' => 'Order not found',
                ],
                404
            );
        }

        $order->status = $data['status'];

        $order->save();

        return response()->json(
            [
                'message' => 'Order status updated successfully',
                'data' => $order,
            ]
        );
    }

    public function orderSummary() : JsonResponse
    {
        $orders = Order::all()->where('timestamps', now());

        $totalOrder = $orders->count();
        $totalOrderCanceled = $orders->where('status', 'canceled')->count();
        $totalOrderDelivery = $orders->where('method_type', 'delivery')->count();
        $totalOrderPickup = $orders->where('method_type', 'pickup')->count();

        return response()->json(
            [
                'total_order' => $totalOrder,
                'total_order_canceled' => $totalOrderCanceled,
                'total_order_delivery' => $totalOrderDelivery,
                'total_order_pickup' => $totalOrderPickup,
            ]
        );
    }


}
