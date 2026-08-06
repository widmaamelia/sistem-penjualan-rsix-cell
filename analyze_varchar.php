<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $tables = DB::select("SELECT table_name as tname, column_name as cname, column_type as ctype, character_maximum_length as clen FROM information_schema.columns WHERE table_schema = DATABASE() AND data_type = 'varchar' AND table_name NOT LIKE 'failed_jobs%' AND table_name NOT LIKE 'migrations%' AND table_name NOT LIKE 'personal_access_tokens%'");
    
    echo "TABLE | COLUMN | TYPE | LENGTH\n";
    foreach ($tables as $t) {
        echo "{$t->tname} | {$t->cname} | {$t->ctype} | {$t->clen}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
