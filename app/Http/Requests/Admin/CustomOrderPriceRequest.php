<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustomOrderPriceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'estimated_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'estimated_price.required' => 'Estimasi harga wajib diisi.',
            'estimated_price.numeric'  => 'Estimasi harga harus berupa angka.',
            'estimated_price.min'      => 'Estimasi harga tidak boleh negatif.',
        ];
    }
}
