<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index() : JsonResponse
    {
        $reviews = Review::all();

        return response()->json([
            'data' => ReviewResource::collection($reviews)
        ]);
    }

    public function store(ReviewRequest $request) : JsonResponse {
        $data = $request->validated();

        $userId = Auth::id();

        $review = new Review();
        $review->user_id = $userId;
        $review->fill($data);

        $review->save();

        return response()->json([
            'messages' => 'Review successfully created',
            'data' => new ReviewResource($review)
        ]);

    }

}
