<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stok_cabangs', function (Blueprint $table) {
            // Kita sudah punya stok_minimum, tapi mungkin nilainya 0. Kita biarkan atau update di DB seeder.
            // Kita hanya perlu tambah stok_maksimal
            if (!Schema::hasColumn('stok_cabangs', 'stok_maksimal')) {
                $table->integer('stok_maksimal')->default(100)->after('stok_minimum');
            }
        });
        
        // Opsional: Update existing rows to have sensible defaults
        \Illuminate\Support\Facades\DB::table('stok_cabangs')->where('stok_minimum', 0)->update(['stok_minimum' => 5]);
    }

    public function down(): void
    {
        Schema::table('stok_cabangs', function (Blueprint $table) {
            if (Schema::hasColumn('stok_cabangs', 'stok_maksimal')) {
                $table->dropColumn('stok_maksimal');
            }
        });
    }
};
