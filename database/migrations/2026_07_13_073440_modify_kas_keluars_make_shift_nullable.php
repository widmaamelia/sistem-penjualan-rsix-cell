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
        Schema::table('kas_keluars', function (Blueprint $table) {
            $table->unsignedInteger('id_shift')->nullable()->change();
            $table->unsignedInteger('id_cabang')->nullable()->after('id_shift');

            $table->foreign('id_cabang')->references('id_cabang')->on('cabangs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('kas_keluars', function (Blueprint $table) {
            $table->dropForeign(['id_cabang']);
            $table->dropColumn('id_cabang');
            $table->unsignedInteger('id_shift')->nullable(false)->change();
        });
    }
};
