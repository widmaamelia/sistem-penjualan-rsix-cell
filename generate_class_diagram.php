<?php

$json = <<<'JSON'
{
    "Cabang": {
        "columns": { "id_cabang": "bigint", "nama_cabang": "varchar", "alamat": "text", "id_penanggung_jawab": "bigint", "no_hp": "varchar", "status": "enum", "created_at": "timestamp" }
    },
    "User": {
        "columns": { "id_user": "bigint", "id_cabang": "bigint", "name": "varchar", "email": "varchar", "password": "varchar", "role": "enum", "status": "enum", "created_at": "timestamp" }
    },
    "KategoriProduk": {
        "columns": { "id_kategori": "bigint", "nama_kategori": "varchar", "deskripsi": "text", "created_at": "timestamp" }
    },
    "Produk": {
        "columns": { "id_produk": "bigint", "id_kategori": "bigint", "sku": "varchar", "nama_produk": "varchar", "harga_beli": "double", "harga_jual": "double", "barcode_imei": "varchar", "status": "enum", "created_at": "timestamp" }
    },
    "StokCabang": {
        "columns": { "id_stok_cabang": "bigint", "id_produk": "bigint", "id_cabang": "bigint", "stok_sekarang": "int", "stok_minimum": "int", "stok_maksimal": "int", "created_at": "timestamp" }
    },
    "LogManajemenStok": {
        "columns": { "id_log_stok": "bigint", "id_cabang": "bigint", "id_produk": "bigint", "id_user": "bigint", "qty": "int", "jenis_transaksi": "enum", "stok_sebelum": "int", "stok_sesudah": "int", "keterangan": "varchar", "tanggal": "datetime", "created_at": "timestamp" }
    },
    "LogPerubahanHarga": {
        "columns": { "id_log_perubahan_harga": "bigint", "id_produk": "bigint", "id_user": "bigint", "harga_beli_lama": "double", "harga_beli_baru": "double", "tanggal": "datetime", "created_at": "timestamp" }
    },
    "MasterShift": {
        "columns": { "id_master_shift": "bigint", "nama_shift": "varchar", "jam_mulai": "time", "jam_selesai": "time", "created_at": "timestamp" }
    },
    "JadwalShift": {
        "columns": { "id_jadwal_shift": "bigint", "id_cabang": "bigint", "id_user": "bigint", "id_master_shift": "bigint", "tanggal": "date", "tipe": "enum", "keterangan": "varchar", "status": "enum", "created_at": "timestamp" }
    },
    "Shift": {
        "columns": { "id_shift": "bigint", "id_user": "bigint", "id_cabang": "bigint", "saldo_awal": "double", "saldo_akhir": "double", "saldo_akhir_sistem": "double", "uang_fisik_tunai": "double", "detail_channel": "json", "selisih": "double", "waktu_buka": "datetime", "waktu_tutup": "datetime", "status": "enum", "created_at": "timestamp" }
    },
    "KasKeluar": {
        "columns": { "id_kas_keluar": "bigint", "id_shift": "bigint", "id_cabang": "bigint", "jumlah_pengeluaran": "double", "keterangan": "varchar", "tanggal": "datetime", "created_at": "timestamp" }
    },
    "Transaksi": {
        "columns": { "id_transaksi": "bigint", "id_user": "bigint", "id_cabang": "bigint", "id_shift": "bigint", "no_transaksi": "varchar", "tanggal_transaksi": "datetime", "total_harga": "double", "metode_bayar": "enum", "uang_bayar": "double", "kembalian": "double", "created_at": "timestamp" }
    },
    "DetailTransaksi": {
        "columns": { "id_detail_transaksi": "bigint", "id_transaksi": "bigint", "id_produk": "bigint", "nama_item_manual": "varchar", "qty": "int", "harga_beli_realtime": "double", "harga_jual_realtime": "double", "sub_total": "double", "nomor_tujuan": "varchar", "kategori_layanan": "varchar", "created_at": "timestamp" }
    },
    "StokOpname": {
        "columns": { "id_stok_opname": "bigint", "id_cabang": "bigint", "id_user": "bigint", "tanggal_opname": "date", "status": "enum", "keterangan": "text", "created_at": "timestamp" }
    },
    "DetailStokOpname": {
        "columns": { "id_detail_stok_opname": "bigint", "id_stok_opname": "bigint", "id_produk": "bigint", "stok_sistem": "int", "stok_fisik": "int", "selisih": "int", "keterangan": "text", "created_at": "timestamp" }
    }
}
JSON;

$schema = json_decode($json, true);

// Perfect 5-column strict layout mapping
$layout = [
    // Column 1
    'KategoriProduk' => ['x' => 100, 'y' => 100],
    'DetailStokOpname' => ['x' => 100, 'y' => 700],
    'LogPerubahanHarga' => ['x' => 100, 'y' => 1300],
    'LogManajemenStok' => ['x' => 100, 'y' => 1900],

    // Column 2
    'Produk' => ['x' => 700, 'y' => 400],
    'StokOpname' => ['x' => 700, 'y' => 1000],
    'StokCabang' => ['x' => 700, 'y' => 1600],

    // Column 3 (Center Hub)
    'MasterShift' => ['x' => 1300, 'y' => 100],
    'Cabang' => ['x' => 1300, 'y' => 1000],
    'User' => ['x' => 1300, 'y' => 1900],

    // Column 4
    'Shift' => ['x' => 1900, 'y' => 400],
    'KasKeluar' => ['x' => 1900, 'y' => 1000],
    'JadwalShift' => ['x' => 1900, 'y' => 1600],

    // Column 5
    'Transaksi' => ['x' => 2500, 'y' => 700],
    'DetailTransaksi' => ['x' => 2500, 'y' => 1300],
];

$relations = [
    ['src' => 'KategoriProduk', 'tgt' => 'Produk', 'label' => '1..*'],
    ['src' => 'Produk', 'tgt' => 'StokCabang', 'label' => '1..*'],
    ['src' => 'Produk', 'tgt' => 'LogManajemenStok', 'label' => '1..*'],
    ['src' => 'Produk', 'tgt' => 'LogPerubahanHarga', 'label' => '1..*'],
    ['src' => 'Produk', 'tgt' => 'DetailTransaksi', 'label' => '1..*'],
    ['src' => 'Produk', 'tgt' => 'DetailStokOpname', 'label' => '1..*'],
    
    ['src' => 'Cabang', 'tgt' => 'User', 'label' => '1..*'],
    ['src' => 'Cabang', 'tgt' => 'StokCabang', 'label' => '1..*'],
    ['src' => 'Cabang', 'tgt' => 'LogManajemenStok', 'label' => '1..*'],
    ['src' => 'Cabang', 'tgt' => 'JadwalShift', 'label' => '1..*'],
    ['src' => 'Cabang', 'tgt' => 'KasKeluar', 'label' => '1..*'],
    ['src' => 'Cabang', 'tgt' => 'Shift', 'label' => '1..*'],
    ['src' => 'Cabang', 'tgt' => 'Transaksi', 'label' => '1..*'],
    ['src' => 'Cabang', 'tgt' => 'StokOpname', 'label' => '1..*'],
    
    ['src' => 'User', 'tgt' => 'LogManajemenStok', 'label' => '1..*'],
    ['src' => 'User', 'tgt' => 'LogPerubahanHarga', 'label' => '1..*'],
    ['src' => 'User', 'tgt' => 'JadwalShift', 'label' => '1..*'],
    ['src' => 'User', 'tgt' => 'Shift', 'label' => '1..*'],
    ['src' => 'User', 'tgt' => 'KasKeluar', 'label' => '1..*'],
    ['src' => 'User', 'tgt' => 'Transaksi', 'label' => '1..*'],
    ['src' => 'User', 'tgt' => 'StokOpname', 'label' => '1..*'],

    ['src' => 'MasterShift', 'tgt' => 'JadwalShift', 'label' => '1..*'],
    ['src' => 'MasterShift', 'tgt' => 'Shift', 'label' => '1..*'],
    ['src' => 'Transaksi', 'tgt' => 'DetailTransaksi', 'label' => '1..*'],
    ['src' => 'StokOpname', 'tgt' => 'DetailStokOpname', 'label' => '1..*'],
    ['src' => 'Shift', 'tgt' => 'KasKeluar', 'label' => '1..*'],
    ['src' => 'Shift', 'tgt' => 'Transaksi', 'label' => '1..*'],
];

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<mxfile host="app.diagrams.net">
  <diagram id="class_diagram_final" name="Class Diagram Rsix Cell">
    <mxGraphModel dx="2500" dy="2500" grid="1" gridSize="20" guides="1" tooltips="1" connect="1" arrows="1" fold="1" page="1" pageScale="1" pageWidth="3200" pageHeight="3200" math="0" shadow="0">
      <root>
        <mxCell id="0" />
        <mxCell id="1" parent="0" />
';

// Draw Classes
foreach ($schema as $modelName => $data) {
    if (!isset($layout[$modelName])) continue;
    
    $pos = $layout[$modelName];
    $x = $pos['x'];
    $y = $pos['y'];
    
    $html = '<p style="margin:0px;margin-top:8px;text-align:center;font-family:Helvetica;font-size:16px;color:#333;"><b>' . $modelName . '</b></p><hr size="1" style="border-color:#b85450;"/>';
    $html .= '<p style="margin:0px;margin-left:12px;font-family:Helvetica;font-size:14px;color:#333;line-height:1.5;">';
    foreach ($data['columns'] as $col => $type) {
        $html .= "- $col: $type<br>";
    }
    $html .= '</p><hr size="1" style="border-color:#b85450;"/>';
    
    $methods = [
        "+ tambah{$modelName}()",
        "+ edit{$modelName}()",
        "+ hapus{$modelName}()"
    ];
    if ($modelName === 'Transaksi') {
        $methods[] = "+ hitungTotal(): double";
    }
    if ($modelName === 'Shift') {
        $methods[] = "+ hitungSelisih(): double";
        $methods[] = "+ tutupShift()";
    }
    
    $html .= '<p style="margin:0px;margin-left:12px;margin-bottom:8px;font-family:Helvetica;font-size:14px;color:#2e8b57;line-height:1.5;">';
    foreach ($methods as $m) {
        $html .= "$m<br>";
    }
    $html .= '</p>';
    
    $escapedHtml = htmlspecialchars($html, ENT_QUOTES | ENT_XML1, 'UTF-8');
    
    $numCols = count($data['columns']);
    $numMethods = count($methods);
    $height = 70 + ($numCols * 21) + ($numMethods * 21);
    
    $classStyle = "html=1;whiteSpace=wrap;overflow=hidden;fillColor=#faebd7;strokeColor=#b85450;align=left;verticalAlign=top;shadow=1;rounded=0;gradientColor=#ffffff;";
    
    $xml .= '        <mxCell id="' . $modelName . '" value="' . $escapedHtml . '" style="' . $classStyle . '" vertex="1" parent="1">
          <mxGeometry x="' . $x . '" y="' . $y . '" width="300" height="' . $height . '" as="geometry" />
        </mxCell>
';
}

// Draw Edges - Let Draw.io auto-route entirely without forcing entry/exit constraints
$edgeId = 1;
foreach ($relations as $rel) {
    $src = $rel['src'];
    $tgt = $rel['tgt'];
    $label = htmlspecialchars($rel['label'], ENT_QUOTES | ENT_XML1, 'UTF-8');
    
    // We use orthogonalEdgeStyle with arc jumps. Removing entryX/Y lets draw.io find the shortest path without wrapping lines around.
    $edgeStyle = "endArrow=open;html=1;edgeStyle=orthogonalEdgeStyle;rounded=1;strokeColor=#4d4d4d;strokeWidth=1.5;fontColor=#333333;fontSize=14;jumpStyle=arc;jumpSize=15;";
    
    $xml .= '        <mxCell id="edge_' . $edgeId . '" value="' . $label . '" style="' . $edgeStyle . '" edge="1" parent="1" source="' . $src . '" target="' . $tgt . '">
          <mxGeometry relative="1" as="geometry">
            <mxPoint as="offset" />
          </mxGeometry>
        </mxCell>
';
    $edgeId++;
}

$xml .= '      </root>
    </mxGraphModel>
  </diagram>
</mxfile>';

file_put_contents('Class_Diagram_Rsix_Cell.drawio', $xml);
echo "Berhasil update algoritma garis dan layout untuk minimalisasi tabrakan.\n";
