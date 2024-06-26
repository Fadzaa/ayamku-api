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
            'status' => $this->status,
            'user' => new UserResource($this->user),
            'cart' => [
                'id' => $this->cart->id,
                'cartItems' => CartItemResource::collection($this->cart->cartItems),
            ],
            'post' => new PostResource($this->post),
        ];
    }
}
