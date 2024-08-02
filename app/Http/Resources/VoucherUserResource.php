<?php

namespace App\Http\Resources;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoucherUserResource extends JsonResource
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
            'used' => $this->used,
            'is_redeemed' => $this->getIsRedeemedAttribute($this->is_redeemed),
            'voucher' => new VoucherResource($this->voucher),
        ];
    }

    public function getIsRedeemedAttribute(int $value): bool
    {
        return boolval($value);
    }
}
