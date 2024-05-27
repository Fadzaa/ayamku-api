<?php

namespace App\Http\Requests\ProductRequest;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|in:geprek,ricebowl,snack,minuman',
            'stock' => 'required|integer',
            'image' => 'required|string',
        ];
    }
}
