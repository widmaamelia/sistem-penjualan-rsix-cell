<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Cabang Utama
        $cabangUtama = Cabang::create([
            'nama_cabang' => 'Cabang Pusat R-Six Cell',
            'alamat' => 'Jl. Jend. Sudirman No. 1, Jakarta Pusat',
            'no_hp' => '081234567890',
            'status' => 'aktif',
        ]);

        // 2. Buat Super Admin
        User::create([
            'id_cabang' => null, // Super admin tidak terikat satu cabang saja
            'name' => 'Super Admin',
            'email' => 'admin@rsixcell.com',
            'password' => Hash::make('password123'),
            'role' => 'super',
            'status' => 'aktif',
        ]);

        // 3. Buat Karyawan di Cabang Utama
        $kasirSatu = User::create([
            'id_cabang' => $cabangUtama->id_cabang,
            'name' => 'Karyawan Satu',
            'email' => 'kasir@rsixcell.com',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
            'status' => 'aktif',
        ]);

        // ==========================================
        // DATA DUMMY UNTUK TESTING DASHBOARD
        // ==========================================
        
        // 4. Buat Kategori & Produk
        $kategori = \App\Models\KategoriProduk::create([
            'nama_kategori' => 'Aksesoris Smartphone'
        ]);

        $produk = \App\Models\Produk::create([
            'id_kategori' => $kategori->id_kategori,
            'sku' => 'CHG-SSG-001',
            'nama_produk' => 'Charger Samsung 25W',
            'harga_beli' => 100000,
            'harga_jual' => 150000,
            'barcode_imei' => '1234567890'
        ]);

        // 5. Buka Shift untuk Kasir Hari Ini
        $shiftAktif = \App\Models\Shift::create([
            'id_user' => $kasirSatu->id_user,
            'id_cabang' => $cabangUtama->id_cabang,
            'saldo_awal' => 500000,
            'waktu_buka' => now()->setTime(7, 0), // Buka jam 7 pagi
            'status' => 'buka'
        ]);

        // 6. Buat Transaksi Penjualan Hari Ini
        $transaksi = \App\Models\Transaksi::create([
            'id_user' => $kasirSatu->id_user,
            'id_cabang' => $cabangUtama->id_cabang,
            'id_shift' => $shiftAktif->id_shift,
            'no_transaksi' => 'TX-' . rand(10000, 99999),
            'tanggal_transaksi' => now(),
            'total_harga' => 300000, // 2x Charger
            'metode_bayar' => 'qris',
            'uang_bayar' => 300000,
            'kembalian' => 0
        ]);

        \App\Models\DetailTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_produk' => $produk->id_produk,
            'qty' => 2,
            'harga_jual_realtime' => 150000,
            'sub_total' => 300000
        ]);
    }
}
