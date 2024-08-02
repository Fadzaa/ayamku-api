<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'code' => 'required|string|unique:vouchers,code',
//            'name' => 'required|string',
            'description' => 'nullable|string',
            'discount' => 'required|integer|min:0',
//            'qty' => 'required|integer|min:0',
            'start_date' => 'required|date|min:0',
            'end_date' => 'required|date|min:0',
        ];
    }
}
