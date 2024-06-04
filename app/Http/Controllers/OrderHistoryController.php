<?php

namespace App\Http\Controllers;

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

        return response()->json($ordersHistory);
    }

    public function show(Request $request) : JsonResponse {
        $userId = Auth::id();

        if ($userId) {
            $orderQuery = Order::all()->where('user_id', $userId)
                ->where('status' , 'completed');

            if ($request->has('filter')) {
                $filter = $request->filter;

                if ($filter === 'latest') {
                    $orderQuery->sortBy('created_at', 'desc');
                } elseif ($filter === '7_days') {
                    $sevenDaysAgo = now()->subDays(7);
                    $orderQuery->where('created_at', '>=', $sevenDaysAgo);
                } elseif ($filter === 'custom_date' && $request->has('date')) {
                    $customDate = $request->date;
                    $orderQuery->where('created_at', $customDate);
                }
            }

            $order = $orderQuery;
        } else {
            $order = [];
        }

        return response()->json($order);
    }
}
