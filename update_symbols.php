<?php
$file = 'Flowchart_Sistem_Saat_Ini.drawio';
$xml = file_get_contents($file);

// 1. Ubah Karyawan Manual Operations (Trapesium Terbalik)
$manual_ops_k = ['k_jual', 'k_uang', 'k_cek', 'k_catat', 'k_bayar'];
foreach ($manual_ops_k as $id) {
    // Cari <mxCell id="ID" ... style="...">
    $xml = preg_replace('/(<mxCell id="' . $id . '"[^>]*style=")([^"]*)(")/i', '$1shape=mxgraph.flowchart.manual_operation;whiteSpace=wrap;html=1;fontSize=14;fillColor=#fff2cc;strokeColor=#d6b656;$3', $xml);
}

// 2. Ubah Pemilik Manual Operations (Trapesium Terbalik)
$manual_ops_p = ['p_datang', 'p_minta', 'p_lihat'];
foreach ($manual_ops_p as $id) {
    $xml = preg_replace('/(<mxCell id="' . $id . '"[^>]*style=")([^"]*)(")/i', '$1shape=mxgraph.flowchart.manual_operation;whiteSpace=wrap;html=1;fontSize=14;fillColor=#d5e8d4;strokeColor=#82b366;$3', $xml);
}

// 3. Ubah s_lap menjadi Display
$xml = preg_replace('/(<mxCell id="s_lap"[^>]*style=")([^"]*)(")/i', '$1shape=display;whiteSpace=wrap;html=1;fontSize=14;fillColor=#dae8fc;strokeColor=#6c8ebf;$3', $xml);
// Update text s_lap just in case
$xml = preg_replace('/(<mxCell id="s_lap"[^>]*value=")([^"]*)(")/i', '$1Menampilkan Laporan Penjualan di Layar$3', $xml);

// 4. Ubah k_catat value
$xml = preg_replace('/(<mxCell id="k_catat"[^>]*value=")([^"]*)(")/i', '$1Catat transaksi manual di buku$3', $xml);

file_put_contents($file, $xml);
echo "Simbol diupdate sesuai tabel standar.\n";
