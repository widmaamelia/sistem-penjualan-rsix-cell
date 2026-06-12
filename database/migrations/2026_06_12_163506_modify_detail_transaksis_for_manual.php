<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            // Drop constraint first
            $table->dropForeign(['id_produk']);
            
            // Modify column
            $table->unsignedBigInteger('id_produk')->nullable()->change();
            
            // Re-add constraint
            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('restrict');

            // Add new column for manual item name
            $table->string('nama_item_manual')->nullable()->after('id_produk');
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->dropColumn('nama_item_manual');
            
            // To revert, drop foreign key, make it not nullable (might fail if there's null data), and re-add constraint
            // This is just for completeness
            $table->dropForeign(['id_produk']);
            $table->unsignedBigInteger('id_produk')->nullable(false)->change();
            $table->foreign('id_produk')->references('id_produk')->on('produks')->onDelete('restrict');
        });
    }
};
