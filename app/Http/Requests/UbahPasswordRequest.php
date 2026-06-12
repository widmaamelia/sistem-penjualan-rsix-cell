<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UbahPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:6',
            'konfirmasi_password_baru' => 'required|string|same:password_baru',
        ];
    }

    public function messages(): array
    {
        return [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'konfirmasi_password_baru.required' => 'Konfirmasi password baru wajib diisi.',
            'konfirmasi_password_baru.same' => 'Konfirmasi password tidak cocok dengan password baru.',
        ];
    }
}
