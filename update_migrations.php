<?php

$migrationsDir = __DIR__ . '/database/migrations/';

$replacements = [
    '0000_01_01_000000_create_cabangs_table.php' => [
        "->string('nama_cabang')" => "->string('nama_cabang', 100)",
        "->string('nama_cabang')->unique()" => "->string('nama_cabang', 100)->unique()"
    ],
    '0001_01_01_000000_create_users_table.php' => [
        "->string('name')" => "->string('name', 100)",
        "->string('email')->unique()" => "->string('email', 100)->unique()",
        "->string('email')" => "->string('email', 100)"
    ],
    '2026_06_11_000001_create_kategori_produks_table.php' => [
        "->string('nama_kategori')" => "->string('nama_kategori', 50)",
        "->string('nama_kategori')->unique()" => "->string('nama_kategori', 50)->unique()"
    ],
    '2026_06_11_000002_create_produks_table.php' => [
        "->string('sku')->unique()" => "->string('sku', 50)->unique()",
        "->string('sku')" => "->string('sku', 50)",
        "->string('nama_produk')" => "->string('nama_produk', 150)",
        "->string('barcode_imei')->nullable()" => "->string('barcode_imei', 50)->nullable()",
        "->string('barcode_imei')" => "->string('barcode_imei', 50)"
    ],
    '2026_07_09_064007_create_master_shifts_table.php' => [
        "->string('nama_shift')" => "->string('nama_shift', 30)"
    ],
    '2026_06_11_000006_create_transaksis_table.php' => [
        "->string('no_transaksi')->unique()" => "->string('no_transaksi', 50)->unique()",
        "->string('no_transaksi')" => "->string('no_transaksi', 50)"
    ],
    '2026_06_11_000007_create_detail_transaksis_table.php' => [
        "->string('nama_item_manual')->nullable()" => "->string('nama_item_manual', 100)->nullable()",
        "->string('nomor_tujuan')->nullable()" => "->string('nomor_tujuan', 30)->nullable()",
        "->string('kategori_layanan')->nullable()" => "->string('kategori_layanan', 50)->nullable()"
    ],
    // detail transaksis manual has a modifier file
    '2026_06_12_163506_modify_detail_transaksis_for_manual.php' => [
        "->string('nama_item_manual')->nullable()" => "->string('nama_item_manual', 100)->nullable()",
        "->string('nomor_tujuan')->nullable()" => "->string('nomor_tujuan', 30)->nullable()",
        "->string('kategori_layanan')->nullable()" => "->string('kategori_layanan', 50)->nullable()"
    ]
];

foreach ($replacements as $file => $changes) {
    $filePath = $migrationsDir . $file;
    if (file_exists($filePath)) {
        $content = file_get_contents($filePath);
        $modified = false;
        foreach ($changes as $search => $replace) {
            if (strpos($content, $replace) === false) { // prevent double replace
                if (strpos($content, $search) !== false) {
                    $content = str_replace($search, $replace, $content);
                    $modified = true;
                    echo "Modified: $search -> $replace in $file\n";
                }
            }
        }
        if ($modified) {
            file_put_contents($filePath, $content);
        }
    } else {
        echo "File not found: $file\n";
    }
}
echo "Selesai memperbarui file migrasi.\n";
