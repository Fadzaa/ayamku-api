<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyVoucherRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderStatusChangeRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\UserVoucher;
use App\Models\Voucher;
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

        $order = new Order();
        $order->user_id = $userId;
        $order->cart_id = $data['cart_id'];
        $order->method_type = $data['method_type'];
        $order->posts_id = $data['posts_id'];
        $order->status = 'processing';

        $voucherResponse = $this->applyVoucher($data['user_voucher_id'], $order);

        if ($voucherResponse instanceof JsonResponse) {
            return $voucherResponse;
        }

        $order->save();

        return response()->json(
            [
                'message' => 'Order created successfully',
                'data' => new OrderResource($order),
            ],
            201
        );
    }

    public function applyVoucher($user_voucher_id, Order $order) :?JsonResponse  {
        $voucherUser = UserVoucher::all()->where('user_id', Auth::id())->where('id', $user_voucher_id)->first();

        if (!$voucherUser) {
            return response()->json(
                [
                    'message' => 'This user does not have this voucher',
                ],
                404
            );
        }

        $voucher = Voucher::all()->where('id', $voucherUser->voucher_id)->first();


        if (!$voucher) {
            return response()->json(
                [
                    'message' => 'Voucher not found',
                ],
                404
            );
        }


        if ($voucher->start_date > now() || $voucher->end_date < now()) {
            return response()->json(
                [
                    'message' => 'Voucher is expired',
                ],
                400
            );
        }

        if ($voucherUser->used) {
            return response()->json(
                [
                    'message' => 'Voucher is already used',
                ],
                400
            );
        }


        $order->voucher_id = $voucher->id;

        $cartItems = $order->cart->cartItems;
        $order_amount = 0;

        foreach ($cartItems as $cartItem) {
            $order_amount += $cartItem->price * $cartItem->quantity;
            $order->discount_amount = $order_amount * $voucher->discount / 100;
            $order->final_amount = $order_amount - $order->discount_amount;
        }

        $voucherUser->used = true;

        $voucherUser->save();

        return null;
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
