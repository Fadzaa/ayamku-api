<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'method_type' => $this->method_type,
            'pickup_time' => $this->pickup_time,
            'shift_delivery' => $this->shift_delivery,
            'status' => $this->status,
            'user' => new UserResource($this->user),
            'cart' => [
                'id' => $this->cart->id,
                'cartItems' => CartItemResource::collection($this->cart->cartItems),
            ],
            'post' => new PostResource($this->post),
            'voucher' => new VoucherResource($this->voucher),
            'discount_amount' => $this->discount_amount,
            'final_amount' => $this->final_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
