<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_cabangs', function (Blueprint $table) {
            $table->increments('id_stok_cabang');
            $table->unsignedInteger('id_produk');
            $table->unsignedInteger('id_cabang');
            $table->integer('stok_sekarang')->default(0);
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
            
            // Mencegah duplikasi produk di cabang yang sama
            $table->unique(['id_produk', 'id_cabang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_cabangs');
    }
};
