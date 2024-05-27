<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() : JsonResponse
    {
        $products = Product::all();

        return response()->json(ProductResource::collection($products));
    }

    public function indexGeprek(Request $request) : JsonResponse
    {
        $products = Product::all()->where('type', 'geprek');

        if ($request->has('search')){
            $products = Product::all()->where('name', 'like', '%'.$request->name.'%');
        }

        return response()->json(ProductResource::collection($products));
    }

    public function indexRicebowl() : JsonResponse
    {
        $products = Product::all()->where('type', 'ricebowl');

        return response()->json(ProductResource::collection($products));
    }

    public function indexSnack() : JsonResponse
    {
        $products = Product::all()->where('type', 'snack');

        return response()->json(ProductResource::collection($products));
    }

    public function indexMinuman() : JsonResponse
    {
        $products = Product::all()->where('type', 'minuman');

        return response()->json(ProductResource::collection($products));
    }

    public function indexTerlaris() : JsonResponse {
        $products = Product::all()->sortByDesc('total_rating')->take(8);

        return response()->json(ProductResource::collection($products));
    }

    public function show(Product $product) : JsonResponse
    {
        return response()->json(new ProductResource($product));
    }

    public function store(ProductRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $product = new Product();
        $product->fill($data);
        $product->save();

        return response()->json(new ProductResource($product), 201);
    }

    public function update(ProductRequest $request, Product $product) : JsonResponse
    {
        $data = $request->validated();

        $product->fill($data);
        $product->save();

        return response()->json(new ProductResource($product));
    }

    public function destroy(Product $product) : JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }

}
