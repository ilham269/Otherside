<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:200'],
            'body'             => ['required', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'meta_title'       => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'status'           => ['required', 'in:draft,published'],
            'thumbnail'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Judul post wajib diisi.',
            'title.max'         => 'Judul maksimal 200 karakter.',
            'body.required'     => 'Konten post wajib diisi.',
            'status.required'   => 'Status wajib dipilih.',
            'status.in'         => 'Status tidak valid.',
            'thumbnail.image'   => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes'   => 'Format thumbnail harus JPG, PNG, atau WebP.',
            'thumbnail.max'     => 'Ukuran thumbnail maksimal 2MB.',
        ];
    }
}
