<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_kategori');
            $table->string('foto_produk')->nullable();
            $table->string('sku')->unique();
            $table->string('nama_produk');
            $table->double('harga_beli', 15, 2);
            $table->double('harga_jual', 15, 2);
            $table->string('barcode_imei')->nullable()->unique();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_produks')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
