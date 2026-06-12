<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukaShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'saldo_awal' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'saldo_awal.required' => 'Saldo awal wajib diisi saat membuka shift.',
            'saldo_awal.numeric' => 'Saldo awal harus berupa angka.',
            'saldo_awal.min' => 'Saldo awal tidak boleh minus.',
        ];
    }
}
