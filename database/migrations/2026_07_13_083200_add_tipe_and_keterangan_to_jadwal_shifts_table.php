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
        Schema::table('jadwal_shifts', function (Blueprint $table) {
            $table->enum('tipe', ['biasa', 'lembur', 'izin'])->default('biasa')->after('tanggal');
            $table->string('keterangan')->nullable()->after('tipe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_shifts', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'keterangan']);
        });
    }
};
