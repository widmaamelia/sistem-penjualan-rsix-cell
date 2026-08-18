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
        Schema::create('jadwal_shifts', function (Blueprint $table) {
            $table->increments('id_jadwal_shift');
            $table->unsignedInteger('id_cabang');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_master_shift');
            $table->date('tanggal');
            $table->enum('status', ['terjadwal', 'berjalan', 'selesai', 'dibatalkan'])->default('terjadwal');
            $table->timestamps();

            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_master_shift')->references('id_master_shift')->on('master_shifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_shifts');
    }
};
