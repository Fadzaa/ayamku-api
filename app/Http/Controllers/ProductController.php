<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest\ProductRequest;
use App\Http\Requests\ProductRequest\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where('name', 'like', "%$search%");
        }

        if ($request->has('category')) {
            $type = $request->query('category');
            $query->where('category', $type);
        }

        $products = $query->get();

        return response()->json(
            [
                'data' => ProductResource::collection($products),
            ]
        );
    }

    public function indexTerlaris() : JsonResponse {
        $products = Product::all()->sortByDesc('total_rating')->take(8);

        return response()->json(
            [
                'data' => ProductResource::collection($products),
            ]
        );
    }

    public function show($id) : JsonResponse
    {
        $product = Product::all()->find($id);

        if ($product === null) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json(
            [
                'data' => new ProductResource($product),
            ]
        );
    }

    public function store(ProductRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $product = new Product();
        $product->fill($data);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->storePublicly('products', 'public');
            $product->image = Storage::url($image);
        }else {
            return response()->json([
                'message' => 'Image not found',
            ], 404);
        }

        $product->save();

        return response()->json([
            'data' => new ProductResource($product),
        ], 201);
    }

    public function update(ProductUpdateRequest $request, $id) : JsonResponse
    {
        $data = $request->validated();

        $product = Product::all()->find($id);

        if ($product === null) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $product->image);
            $image = $request->file('image')->storePublicly('products', 'public');
            $data['image'] = Storage::url($image);
        }

        $product->fill($data);
        $product->save();

        return response()->json(
            [
                'data' => new ProductResource($product),
            ]
        );
    }

    public function destroy($id) : JsonResponse
    {
        $product = Product::all()->find($id);

        if ($product === null) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product successfully deleted',
        ], 200);
    }

}
