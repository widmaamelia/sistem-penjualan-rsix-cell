<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stok_cabangs', function (Blueprint $table) {
            $table->integer('stok_minimum')->default(0)->after('stok_sekarang');
        });
    }

    public function down(): void
    {
        Schema::table('stok_cabangs', function (Blueprint $table) {
            $table->dropColumn('stok_minimum');
        });
    }
};
