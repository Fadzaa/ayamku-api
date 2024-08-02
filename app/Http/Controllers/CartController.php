<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\UpdateQtyCartitem;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCartByUser() : JsonResponse
    {
        $userId = Auth::id();


        $cart = Cart::all()->where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(
                [
                    'message' => 'This user has no cart yet.'
                ],
                404
            );
        }

        $cartItems = CartItem::with('product')->where('cart_id', $cart->id)->get();

        $totalPrice = 0;
        $cartItemsArray = $cartItems->map(function ($cartItem) {
            return new CartItemResource($cartItem);
        });

        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->quantity * $cartItem->price;
        }

        $cart->cartItems = $cartItemsArray;
        $cart->total_price = $totalPrice;


        return response()->json(
            [
                'cart' => new CartResource($cart),
            ]
        );
    }

    public function storeCart(CartRequest $request): JsonResponse
    {
        $userId = Auth::id();

        $cart = Cart::all()->where('user_id', $userId)->first();

        if ($cart != null) {
            return $this->addCartItem($cart->id ,$request);
        } else {
            $cart = new Cart();
            $cart['user_id'] = $userId;
            $cart->save();

            return $this->addCartItem($cart->id, $request);
        }

    }

    public function addCartItem($cartId, CartRequest $request) : JsonResponse {
        $data = $request->validated();

        $existingCartItem = CartItem::all()->where('cart_id', $cartId)
            ->where('product_id', $data['product_id'])
            ->first();

        $product = Product::all()->where('id', $data['product_id'])->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $data['quantity'];
            $existingCartItem->save();
        } else {
            $cartItem = new CartItem();
            $cartItem->cart_id = $cartId;
            $cartItem->price = $product->price;
            $cartItem->fill($data);
            $cartItem->save();

            return response()->json(
                [
                    'message' => 'Cart item added successfully.',
                    'cart' => new CartItemResource($cartItem),
                ]
            );
        }

        return response()->json(
            [
                'message' => 'Cart item updated successfully.',
                'cart' => new CartItemResource($existingCartItem),
            ]
        );
    }

    public function updateCartItem(UpdateQtyCartitem $request) : JsonResponse {
        $data = $request->validated();

        $cartItem = CartItem::all()->where('id', $data['cart_item_id'])->first();

        if ($cartItem) {
            $cartItem->quantity = $data['quantity'];

            if ($cartItem->quantity <= 0) {
                $cartItem->delete();

                return response()->json([
                    'message' => 'Cart item removed successfully'
                ]);
            } else {
                $cartItem->save();

                return response()->json([
                    'message' => 'Cart item updated successfully'
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Cart item not found',
                'test' => $cartItem
            ], 404);
        }
    }



}
