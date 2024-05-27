<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoRequest;
use App\Http\Requests\PromoUpdateRequest;
use App\Http\Resources\PromoResource;
use App\Models\Promo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $promos = Promo::all();

        if ($request->has('search')) {
            $promos = Promo::query()->where('name', 'like', '%' . $request->search . '%')->get();
        }

        return response()->json(
            [
                'data' => PromoResource::collection($promos)
            ]
        );
    }

    public function indexActivePromo() : JsonResponse
    {
        $promos = Promo::query()->where('start_date', '<=', now())->where('end_date', '>=', now())->get();

        return response()->json(
            [
                'data' => PromoResource::collection($promos)
            ]
        );
    }

    public function store(PromoRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $promo = new Promo();
        $promo->fill($data);
        $promo->save();

        return response()->json(
            [
                'data' => new PromoResource($promo)
            ],
            201
        );

    }

    public function update(PromoUpdateRequest $request, $id) : JsonResponse
    {
        $data = $request->validated();

        $promo = Promo::all()->find($id);
        $promo->fill($data);
        $promo->save();

        return response()->json(
            [
                'data' => new PromoResource($promo)
            ]
        );

    }

    public function destroy($id) : JsonResponse
    {
        $promo = Promo::all()->find($id);
        $promo->delete();

        return response()->json(
            [
                'message' => 'Promo deleted'
            ]
        );

    }



}
