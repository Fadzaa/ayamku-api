<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'user_name' => $this->user->name,
            'images' => ReviewImageResource::collection($this->images),
            'product_name' => $this->product->name,
            'order_id' => $this->order_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ];
    }
}
