<?php

namespace App\Http\Controllers;

use App\Models\StoreStatus;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class StoreStatusController extends Controller
{
    public function getStoreStatus()
    {
        $status = StoreStatus::all()->first();
        return response()->json(
            [
                'store_status' => $status->is_open,
                'description' => $status->is_open ? 'Store is open' : 'Store is closed'
            ]
        );
    }

    public function updateStoreStatus()
    {
        $status = StoreStatus::all()->first();
        $status->is_open = !$status->is_open;
        $status->save();

        return response()->json(['message' => 'Store status updated successfully']);
    }

    public function updateStockProduct(Request $request)
    {
        $status = StoreStatus::all()->first();
        $status->stock_product = $request->stock_product;
        $status->save();

        return response()->json(['message' => 'Stock product updated successfully']);
    }


}
