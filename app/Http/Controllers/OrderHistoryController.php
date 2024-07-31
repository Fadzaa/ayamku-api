<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index(Request $request) : JsonResponse {
        $ordersHistory = Order::all()->where('status' , 'completed')->sortByDesc('created_at');

        if ($request->has('method_type')) {
            $ordersHistory = $ordersHistory->where('method_type', $request->method_type)->sortByDesc('created_at');
        }

        return response()->json([
            'data' => OrderResource::collection($ordersHistory)
        ]);
    }

    public function show(Request $request) : JsonResponse {
        $userId = Auth::id();

        if ($userId) {
            $orderQuery = Order::query()->where('user_id', $userId)->where('status', 'completed');

            if ($request->has('filter')) {

                $filter = $request->query('filter');

                if ($filter === 'latest') {
                    $orderQuery->orderBy('created_at', 'desc');
                }

                if ($filter === '7_days') {
                    $sevenDaysAgo = now()->subDays(7);
                    $orderQuery->whereDate('created_at', '>=', $sevenDaysAgo);
                }

                if ($filter === 'custom_date' && $request->has('date')) {
                    $customDate = $request->query('date');
                    $orderQuery->whereDate('created_at', $customDate);
                }
            }

            $order = $orderQuery->get();
        } else {
            return response()->json(
                [
                    'message' => 'User not found',
                ]
            );
        }

        return response()->json(
            [
                'data' => OrderResource::collection($order),
            ]
        );
    }
}
