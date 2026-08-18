<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->increments('id_shift');
            $table->unsignedInteger('id_user');
            $table->unsignedInteger('id_cabang');
            $table->double('saldo_awal', 15, 2);
            $table->double('saldo_akhir', 15, 2)->nullable();
            $table->dateTime('waktu_buka');
            $table->dateTime('waktu_tutup')->nullable();
            $table->enum('status', ['buka', 'tutup'])->default('buka');
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('restrict');
            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
