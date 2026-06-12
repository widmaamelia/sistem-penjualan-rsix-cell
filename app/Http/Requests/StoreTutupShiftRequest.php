<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTutupShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uang_fisik_tunai' => 'required|numeric|min:0',
            'detail_channel' => 'nullable|array' // contoh: {"BRI": 50000, "BNI": 0}
        ];
    }

    public function messages(): array
    {
        return [
            'uang_fisik_tunai.required' => 'Jumlah uang fisik tunai wajib diisi.',
            'uang_fisik_tunai.numeric' => 'Uang fisik tunai harus berupa angka.',
            'uang_fisik_tunai.min' => 'Uang fisik tunai tidak boleh minus.',
            'detail_channel.array' => 'Format detail channel tidak valid.'
        ];
    }
}
