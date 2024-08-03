<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cart_id' => 'required|integer|exists:carts,id',
            'method_type' => 'required|string|in:on_delivery,pickup',
            'posts_id' => 'required|integer|exists:posts,id',
            'user_voucher_id' => 'nullable|integer',
//            'status' => 'required|string|max:255',
        ];
    }
}
