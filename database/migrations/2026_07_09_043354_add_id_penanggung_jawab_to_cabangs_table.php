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
        Schema::table('cabangs', function (Blueprint $table) {
            $table->unsignedInteger('id_penanggung_jawab')->nullable()->after('alamat');
            $table->foreign('id_penanggung_jawab')->references('id_user')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cabangs', function (Blueprint $table) {
            $table->dropForeign(['id_penanggung_jawab']);
            $table->dropColumn('id_penanggung_jawab');
        });
    }
};
