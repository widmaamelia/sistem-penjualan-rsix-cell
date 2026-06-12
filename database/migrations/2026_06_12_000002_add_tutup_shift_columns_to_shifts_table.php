<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->double('saldo_akhir_sistem', 15, 2)->nullable()->after('saldo_akhir');
            $table->double('uang_fisik_tunai', 15, 2)->nullable()->after('saldo_akhir_sistem');
            $table->json('detail_channel')->nullable()->after('uang_fisik_tunai');
            $table->double('selisih', 15, 2)->nullable()->after('detail_channel');
        });
    }

    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropColumn(['saldo_akhir_sistem', 'uang_fisik_tunai', 'detail_channel', 'selisih']);
        });
    }
};
