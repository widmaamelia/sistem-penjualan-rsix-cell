<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stok_opnames', function (Blueprint $table) {
            $table->id('id_stok_opname');
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_user'); // Admin cabang yang submit
            $table->date('tanggal_opname');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });

        Schema::create('detail_stok_opnames', function (Blueprint $table) {
            $table->id('id_detail_stok_opname');
            $table->unsignedBigInteger('id_stok_opname');
            $table->unsignedBigInteger('id_produk');
            $table->integer('stok_sistem');
            $table->integer('stok_fisik');
            $table->integer('selisih');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_stok_opname')->references('id_stok_opname')->on('stok_opnames')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_stok_opnames');
        Schema::dropIfExists('stok_opnames');
    }
};
