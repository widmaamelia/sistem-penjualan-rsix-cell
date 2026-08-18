<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_keluars', function (Blueprint $table) {
            $table->increments('id_kas_keluar');
            $table->unsignedInteger('id_shift');
            $table->double('jumlah_pengeluaran', 15, 2);
            $table->text('keterangan');
            $table->dateTime('tanggal');
            $table->timestamps();

            $table->foreign('id_shift')->references('id_shift')->on('shifts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_keluars');
    }
};
