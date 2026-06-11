<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKasKeluarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Asumsikan otorisasi sudah dihandle oleh Sanctum
    }

    public function rules(): array
    {
        return [
            'jumlah_pengeluaran' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'jumlah_pengeluaran.required' => 'Jumlah pengeluaran wajib diisi.',
            'jumlah_pengeluaran.numeric' => 'Jumlah pengeluaran harus berupa angka.',
            'jumlah_pengeluaran.min' => 'Jumlah pengeluaran minimal adalah 1.',
            'keterangan.required' => 'Keterangan wajib diisi.',
            'keterangan.max' => 'Keterangan maksimal 255 karakter.',
        ];
    }
}
