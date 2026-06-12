<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'metode_pembayaran' => 'required|string|in:Tunai,Transfer,QRIS,tunai,transfer,qris',
            'items' => 'required|array|min:1',
            'items.*.tipe' => 'required|in:fisik,manual',
            
            // Aturan untuk produk fisik
            'items.*.id_produk' => 'required_if:items.*.tipe,fisik|integer|exists:produks,id_produk',
            
            // Aturan untuk produk manual
            'items.*.nama_item_manual' => 'required_if:items.*.tipe,manual|string|max:255',
            'items.*.kategori_layanan' => 'required_if:items.*.tipe,manual|string|max:255',
            'items.*.harga_beli' => 'required_if:items.*.tipe,manual|numeric|min:0',
            'items.*.harga_jual' => 'required_if:items.*.tipe,manual|numeric|min:0',
            'items.*.nomor_tujuan' => 'nullable|string|max:255',
            
            // Umum
            'items.*.qty' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'metode_pembayaran.required' => 'Metode pembayaran harus diisi.',
            'items.required' => 'Keranjang belanja tidak boleh kosong.',
            'items.*.id_produk.required_if' => 'ID Produk wajib diisi untuk barang fisik.',
            'items.*.nama_item_manual.required_if' => 'Nama item wajib diisi untuk transaksi manual.',
            'items.*.harga_jual.required_if' => 'Harga jual wajib diisi untuk transaksi manual.'
        ];
    }
}
