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

        $query = Order::query();

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', date('Y-m-d'));
                break;
            case 'week':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', date('m'));
                break;
        }

        $total_sales = $query->sum('final_amount');
        $total_order = $query->count();

        $total_product = 0;

        foreach ($query->get() as $order) {
            $order->cart->cartItems->each(function ($item) use (&$total_product) {
                $total_product += $item->quantity;
            });
        }





        $data = [
            'total_sales' => $total_sales,
            'total_order' => $total_order,
            'total_product' => $total_product
        ];

        return response()->json($data);
    }
}
