<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StokDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabangUtama = \App\Models\Cabang::first();

        // 1. Kategori Aksesoris Apple
        $kategoriApple = \App\Models\KategoriProduk::create([
            'nama_kategori' => 'Aksesoris Apple'
        ]);

        $produkApple = \App\Models\Produk::create([
            'id_kategori' => $kategoriApple->id_kategori,
            'sku' => 'IPH-15-MAT',
            'nama_produk' => 'iPhone 15 Case Matte',
            'harga_beli' => 50000,
            'harga_jual' => 100000,
            'barcode_imei' => '8881234567890'
        ]);

        \App\Models\StokCabang::create([
            'id_produk' => $produkApple->id_produk,
            'id_cabang' => $cabangUtama->id_cabang,
            'stok_sekarang' => 0,
            'stok_minimum' => 50
        ]);

        // 2. Kategori Aksesoris Universal
        $kategoriUniv = \App\Models\KategoriProduk::create([
            'nama_kategori' => 'Aksesoris Universal'
        ]);

        $produkTG = \App\Models\Produk::create([
            'id_kategori' => $kategoriUniv->id_kategori,
            'sku' => 'TG-PRO-UNV',
            'nama_produk' => 'Tempered Glass Pro',
            'harga_beli' => 20000,
            'harga_jual' => 45000,
            'barcode_imei' => '8881234567891'
        ]);

        \App\Models\StokCabang::create([
            'id_produk' => $produkTG->id_produk,
            'id_cabang' => $cabangUtama->id_cabang,
            'stok_sekarang' => 5,
            'stok_minimum' => 100
        ]);

        // 3. Kategori Power Samsung
        $kategoriPower = \App\Models\KategoriProduk::create([
            'nama_kategori' => 'Power Samsung'
        ]);

        $produkCharger = \App\Models\Produk::create([
            'id_kategori' => $kategoriPower->id_kategori,
            'sku' => 'CHG-20W-SSG',
            'nama_produk' => 'Charger 20W Fast',
            'harga_beli' => 80000,
            'harga_jual' => 150000,
            'barcode_imei' => '8881234567892'
        ]);

        \App\Models\StokCabang::create([
            'id_produk' => $produkCharger->id_produk,
            'id_cabang' => $cabangUtama->id_cabang,
            'stok_sekarang' => 85,
            'stok_minimum' => 100
        ]);
    }
}
