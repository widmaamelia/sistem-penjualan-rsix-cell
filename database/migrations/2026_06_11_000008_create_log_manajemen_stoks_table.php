<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_manajemen_stoks', function (Blueprint $table) {
            $table->increments('id_log_stok');
            $table->unsignedInteger('id_cabang');
            $table->unsignedInteger('id_produk');
            $table->unsignedInteger('id_user'); // Siapa yang merubah/transaksi
            $table->integer('qty');
            $table->enum('jenis_transaksi', ['masuk', 'keluar', 'penjualan', 'retur']);
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->text('keterangan')->nullable();
            $table->dateTime('tanggal');
            $table->timestamps();

            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_manajemen_stoks');
    }
};
