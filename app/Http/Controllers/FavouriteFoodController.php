<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavouriteFoodRequest;
use App\Models\FavouriteFood;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteFoodController extends Controller
{
    public function index() : JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $favouriteFoods = FavouriteFood::all()->where('user_id', $user->id);

        return response()->json([
            'message' => 'success',
            'data' => $favouriteFoods
        ]);
    }

    public function store(FavouriteFoodRequest $request) : JsonResponse {
        $data = $request->validated();

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $favouriteFood = new FavouriteFood();
        $favouriteFood->user_id = $user->id;
        $favouriteFood->product_id = $data['product_id'];
        $favouriteFood->save();

        return response()->json([
            'message' => 'success',
            'data' => $favouriteFood
        ]);
    }

    public function destroy($productId) : JsonResponse {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }
        $favouriteFood = FavouriteFood::all()
            ->where('product_id', $productId)
            ->where('user_id', $user->id)
            ->first();

        if (!$favouriteFood) {
            return response()->json([
                'message' => 'Favourite food not found.'
            ], 404);
        }

        if ($favouriteFood->user_id != $user->id) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $favouriteFood->delete();

        return response()->json([
            'message' => 'Delete Favourite Food Successfully'
        ]);
    }
}
