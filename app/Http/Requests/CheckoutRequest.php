<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $maxStock = $this->route('product')?->stock ?? 999;

        return [
            'customer_name'       => ['required', 'string', 'max:100'],
            'customer_phone'      => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'customer_email'      => ['required', 'email', 'max:150'],
            'qty'                 => ['required', 'integer', 'min:1', 'max:' . $maxStock],
            'shipping_address'    => ['required', 'string', 'max:255'],
            'shipping_city'       => ['required', 'string', 'max:100'],
            'shipping_province'   => ['required', 'string', 'max:100'],
            'shipping_postal_code'=> ['required', 'digits_between:4,6'],
            'shipping_notes'      => ['nullable', 'string', 'max:300'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required'        => 'Nama lengkap wajib diisi.',
            'customer_phone.required'       => 'No. telepon wajib diisi.',
            'customer_phone.regex'          => 'Format no. telepon tidak valid.',
            'customer_email.required'       => 'Email wajib diisi.',
            'customer_email.email'          => 'Format email tidak valid.',
            'qty.required'                  => 'Jumlah wajib diisi.',
            'qty.min'                       => 'Jumlah minimal 1.',
            'qty.max'                       => 'Jumlah melebihi stok tersedia.',
            'shipping_address.required'     => 'Alamat pengiriman wajib diisi.',
            'shipping_city.required'        => 'Kota wajib diisi.',
            'shipping_province.required'    => 'Provinsi wajib diisi.',
            'shipping_postal_code.required' => 'Kode pos wajib diisi.',
            'shipping_postal_code.digits_between' => 'Kode pos harus 4-6 digit.',
        ];
    }
}
