<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherUpdateRequest extends FormRequest
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
            'code' => 'string|unique:vouchers,code',
            'name' => 'string',
            'description' => 'nullable|string',
            'discount' => 'integer|min:0',
            'qty' => 'integer|min:0',
            'start_date' => 'date|min:0',
            'end_date' => 'date|min:0',
        ];
    }
}
