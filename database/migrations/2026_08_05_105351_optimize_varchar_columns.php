<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // cabangs
        DB::statement('ALTER TABLE cabangs MODIFY nama_cabang VARCHAR(100) NOT NULL');
        
        // detail_transaksis
        DB::statement('ALTER TABLE detail_transaksis MODIFY nama_item_manual VARCHAR(100) NULL');
        DB::statement('ALTER TABLE detail_transaksis MODIFY nomor_tujuan VARCHAR(30) NULL');
        DB::statement('ALTER TABLE detail_transaksis MODIFY kategori_layanan VARCHAR(50) NULL');
        
        // kategori_produks
        DB::statement('ALTER TABLE kategori_produks MODIFY nama_kategori VARCHAR(50) NOT NULL');
        
        // master_shifts
        DB::statement('ALTER TABLE master_shifts MODIFY nama_shift VARCHAR(30) NOT NULL');
        
        // produks
        DB::statement('ALTER TABLE produks MODIFY sku VARCHAR(50) NOT NULL');
        DB::statement('ALTER TABLE produks MODIFY nama_produk VARCHAR(150) NOT NULL');
        DB::statement('ALTER TABLE produks MODIFY barcode_imei VARCHAR(50) NULL');
        
        // transaksis
        DB::statement('ALTER TABLE transaksis MODIFY no_transaksi VARCHAR(50) NOT NULL');
        
        // users
        DB::statement('ALTER TABLE users MODIFY name VARCHAR(100) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY email VARCHAR(100) NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to 255
        DB::statement('ALTER TABLE cabangs MODIFY nama_cabang VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE detail_transaksis MODIFY nama_item_manual VARCHAR(255) NULL');
        DB::statement('ALTER TABLE detail_transaksis MODIFY nomor_tujuan VARCHAR(255) NULL');
        DB::statement('ALTER TABLE detail_transaksis MODIFY kategori_layanan VARCHAR(255) NULL');
        DB::statement('ALTER TABLE kategori_produks MODIFY nama_kategori VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE master_shifts MODIFY nama_shift VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE produks MODIFY sku VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE produks MODIFY nama_produk VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE produks MODIFY barcode_imei VARCHAR(255) NULL');
        DB::statement('ALTER TABLE transaksis MODIFY no_transaksi VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY name VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY email VARCHAR(255) NOT NULL');
    }
};
