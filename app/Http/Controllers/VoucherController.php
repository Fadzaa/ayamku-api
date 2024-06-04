<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiveVoucherRequest;
use App\Http\Requests\VoucherRequest;
use App\Http\Requests\VoucherUpdateRequest;
use App\Http\Resources\VoucherResource;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index() : JsonResponse
    {
        $vouchers = Voucher::all();

        return response()->json([
            'data' => VoucherResource::collection($vouchers)
        ]);
    }

    public function store(VoucherRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $voucher = new Voucher();
        $voucher->fill($data);
        $voucher->save();

        return response()->json([
            'message' => 'Voucher created successfully',
            'data' => new VoucherResource($voucher)
        ], 201);
    }

    public function update(VoucherUpdateRequest $request, $id) : JsonResponse
    {
        $data = $request->validated();

        $voucher = Voucher::all()->find($id);
        $voucher->fill($data);
        $voucher->save();

        return response()->json([
            'message' => 'Voucher updated successfully',
            'data' => new VoucherResource($voucher)
        ]);
    }

    public function destroy($id) : JsonResponse
    {
        $voucher = Voucher::all()->find($id);
        $voucher->delete();

        return response()->json([
            'message' => 'Voucher deleted successfully'
        ]);
    }

    public function currentUserVoucher() : JsonResponse
    {
        $userId = Auth::id();
        $vouchers = Voucher::all()->where('user_id', $userId);

        return response()->json([
            'data' => VoucherResource::collection($vouchers)
        ]);
    }

    public function giveVoucher(GiveVoucherRequest $request) : JsonResponse
    {

        $data = $request->validated();

        $userVoucher = new UserVoucher();
        $userVoucher->fill($data);

        $userVoucher->save();

        return response()->json([
            'message' => 'Voucher given successfully'
        ]);

    }
}
