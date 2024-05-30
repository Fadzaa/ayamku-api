<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCartByUser($userId) : JsonResponse
    {
        $cart = Cart::all()->where('user_id', $userId)->first();
        $cartItems = CartItem::all()->where('cart_id', $cart->id);

        $cart->cartItems = $cartItems;
        return response()->json(
            [
                'cart' => $cart,
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
            $cart->user_id = $userId;
            $cart->save();

            return $this->addCartItem($cart->id, $request);
        }

    }

    public function addCartItem($cartId, CartRequest $request) : JsonResponse {
        $data = $request->validated();

        $cartItem = new CartItem();
        $cartItem->cart_id = $cartId;
        $cartItem->fill($data);
        $cartItem->save();

        return response()->json(
            [
                'cart' => new CartItemResource($cartItem),
            ]
        );
    }



}
