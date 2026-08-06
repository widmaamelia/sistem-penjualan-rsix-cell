<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_shift');
            $table->string('no_transaksi', 50)->unique();
            $table->dateTime('tanggal_transaksi');
            $table->double('total_harga', 15, 2);
            $table->enum('metode_bayar', ['tunai', 'qris', 'transfer'])->default('tunai');
            $table->double('uang_bayar', 15, 2);
            $table->double('kembalian', 15, 2);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('restrict');
            $table->foreign('id_shift')->references('id_shift')->on('shifts')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
