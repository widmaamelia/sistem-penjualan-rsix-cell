<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$models = [
    'Cabang', 'User', 'KategoriProduk', 'Produk', 'StokCabang', 
    'LogManajemenStok', 'LogPerubahanHarga', 'MasterShift', 'JadwalShift', 
    'Shift', 'KasKeluar', 'Transaksi', 'DetailTransaksi', 'StokOpname', 'DetailStokOpname'
];

$output = [];

foreach ($models as $modelName) {
    $class = '\\App\\Models\\' . $modelName;
    if (!class_exists($class)) continue;
    
    $obj = new $class;
    $table = $obj->getTable();
    
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
    $types = [];
    foreach ($columns as $col) {
        $type = \Illuminate\Support\Facades\Schema::getColumnType($table, $col);
        $types[$col] = $type;
    }
    
    // Get methods using reflection
    $ref = new ReflectionClass($class);
    $methods = [];
    foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if ($method->class == $class) {
            $methods[] = $method->getName();
        }
    }
    
    $output[$modelName] = [
        'table' => $table,
        'columns' => $types,
        'methods' => $methods
    ];
}

echo json_encode($output, JSON_PRETTY_PRINT);
