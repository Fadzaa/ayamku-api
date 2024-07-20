<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\StoreStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticController extends Controller
{
    public function salesSummary(Request $request) {
        $filter = $request->get('filter', 'today');

        $query = Order::join('carts', 'orders.cart_id', '=', 'carts.id')
            ->join('cart_items', 'carts.id', '=', 'cart_items.cart_id');

        switch ($filter) {
            case 'today':
                $query->whereDate('orders.created_at', date('Y-m-d'));
                break;
            case 'week':
                $query->whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('orders.created_at', date('m'));
                break;
        }

        $total_sales = $query->sum(DB::raw('cart_items.quantity * cart_items.price'));
        $total_order = $query->count();

        $total_product = StoreStatus::all()->pluck('stock_product');

        $data = [
            'total_sales' => $total_sales,
            'total_order' => $total_order,
            'total_product' => $total_product
        ];

        return response()->json($data);
    }
}
