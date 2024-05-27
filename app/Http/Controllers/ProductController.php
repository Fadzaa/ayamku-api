<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest\ProductRequest;
use App\Http\Requests\ProductRequest\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() : JsonResponse
    {
        $products = Product::all();

        return response()->json(
            [
                'data' => ProductResource::collection($products),
            ]
        );
    }

    public function indexGeprek(Request $request) : JsonResponse
    {

        $products = Product::all()->where('type', 'geprek');

        if ($request->has('search')) {
            $search = $request->query('search');
            $products = $products->filter(function ($product) use ($search) {
                return false !== stristr($product->name, $search);
            });
        }

        return response()->json(
            [
                'data' => ProductResource::collection($products),
            ]
        );
    }

    public function indexRicebowl(Request $request) : JsonResponse
    {
        $products = Product::all()->where('type', 'ricebowl');


        if ($request->has('search')) {
            $search = $request->query('search');
            $products = $products->filter(function ($product) use ($search) {
                return false !== stristr($product->name, $search);
            });
        }

        return response()->json(
            [
                'data' => ProductResource::collection($products),
            ]
        );
    }

    public function indexSnack(Request $request) : JsonResponse
    {
        $products = Product::all()->where('type', 'snack');

        if ($request->has('search')) {
            $search = $request->query('search');
            $products = $products->filter(function ($product) use ($search) {
                return false !== stristr($product->name, $search);
            });
        }

        return response()->json(
            [
                'data' => ProductResource::collection($products),
            ]
        );
    }

    public function indexMinuman(Request $request) : JsonResponse
    {
        $products = Product::all()->where('type', 'minuman');

        if ($request->has('search')) {
            $search = $request->query('search');
            $products = $products->filter(function ($product) use ($search) {
                return false !== stristr($product->name, $search);
            });
        }

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
