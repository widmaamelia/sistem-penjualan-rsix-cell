<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->integer('qty');
            $table->double('harga_jual_realtime', 15, 2); // Harga saat transaksi terjadi
            $table->double('sub_total', 15, 2);
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
