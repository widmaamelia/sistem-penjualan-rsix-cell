<?php
// Script untuk men-generate Test Case Blackbox yang Dikelompokkan Berdasarkan 3 Role (Super, Admin Cabang, Karyawan)
$filename = "C:\\Users\\AThariz\\.gemini\\antigravity-ide\\brain\\5fd1bcfd-077a-4e03-bb50-7a8890669438\\Test_Case_Blackbox_Rsix_Per_Role.xls";

// Kolom sesuai format standar
$columns = ["ID Skenario", "Modul / Fitur", "Jenis Uji", "Deskripsi Pengujian", "Langkah-Langkah (Skenario)", "Hasil yang Diharapkan", "Hasil Aktual", "Status"];

$roles_data = [
    "ROLE: SUPER ADMIN (Pusat / Web)" => [
        ["SUP-01", "Autentikasi", "Valid", "Login Super Admin", "1. Buka Web\n2. Masukkan email & password Super Admin\n3. Klik Login", "Mengarahkan ke Dashboard Web", "", ""],
        ["SUP-02", "Master Cabang", "Valid", "Tambah Cabang Baru", "1. Ke menu Cabang\n2. Klik Tambah\n3. Isi form\n4. Simpan", "Cabang baru tersimpan di database", "", ""],
        ["SUP-03", "Master Pengguna", "Valid", "Tambah Akun Karyawan/Admin", "1. Ke menu Pengguna\n2. Isi form & pilih role\n3. Simpan", "Akun berhasil dibuat", "", ""],
        ["SUP-04", "Master Shift", "Valid", "Tambah Master Shift", "1. Ke menu Master Shift\n2. Input shift (Pagi/Siang)\n3. Simpan", "Master shift berhasil dibuat", "", ""],
        ["SUP-05", "Master Kategori", "Valid", "Tambah Kategori", "1. Ke Master Kategori\n2. Isi nama kategori\n3. Simpan", "Kategori produk tersimpan", "", ""],
        ["SUP-06", "Manajemen Produk", "Valid", "Tambah Produk (Fisik & Digital)", "1. Ke Master Produk\n2. Input detail produk & pilih kategori\n3. Simpan", "Produk berhasil ditambahkan ke katalog", "", ""],
        ["SUP-07", "Manajemen Stok", "Valid", "Input Stok Masuk & Pindah Stok", "1. Ke menu Stok\n2. Pilih produk & cabang\n3. Input QTY\n4. Simpan", "Stok cabang bertambah/berpindah", "", ""],
        ["SUP-08", "Stok Opname", "Valid", "Approve/Reject Stok Opname", "1. Ke menu Opname\n2. Klik Approve pada pengajuan cabang", "Stok tersesuaikan sesuai selisih opname", "", ""],
        ["SUP-09", "Laporan", "Valid", "Lihat & Export Laporan Semua Cabang", "1. Ke Laporan\n2. Pilih Cabang = 'Semua'\n3. Filter Tanggal\n4. Export", "Laporan terunduh menampilkan rekap semua cabang", "", ""]
    ],
    "ROLE: ADMIN CABANG (Cabang / Web)" => [
        ["ADM-01", "Autentikasi", "Valid", "Login Admin Cabang", "1. Buka Web\n2. Input email & pass Admin Cabang\n3. Klik Login", "Mengarahkan ke Dashboard (menu terbatas)", "", ""],
        ["ADM-02", "Hak Akses (Security)", "Invalid", "Akses menu Master Cabang/Pengguna", "1. Coba akses URL /cabang atau /pengguna secara manual", "Sistem memblokir akses (Akses ditolak/Redirect)", "", ""],
        ["ADM-03", "Manajemen Produk", "Valid", "Edit Produk (Harga/Detail)", "1. Ke menu Produk\n2. Klik Edit\n3. Ubah Harga\n4. Simpan", "Harga produk berhasil diperbarui", "", ""],
        ["ADM-04", "Manajemen Stok", "Valid", "Input Stok Masuk Cabang Sendiri", "1. Ke menu Stok Masuk\n2. Input produk & QTY\n3. Simpan", "Stok cabang tersebut bertambah", "", ""],
        ["ADM-05", "Manajemen Stok", "Invalid", "Input Stok Masuk untuk Cabang Lain", "1. Di menu Stok Masuk\n2. Coba pilih Cabang Lain", "Pilihan cabang lain tidak tersedia (ter-lock)", "", ""],
        ["ADM-06", "Stok Opname", "Valid", "Pengajuan Stok Opname", "1. Ke menu Opname\n2. Input stok fisik komputer & aktual\n3. Simpan", "Status menjadi 'Pending' menunggu approval Super Admin", "", ""],
        ["ADM-07", "Kas Keluar", "Valid", "Input Kas Keluar Harian", "1. Ke menu Kas Keluar\n2. Input pengeluaran\n3. Simpan", "Kas keluar tercatat", "", ""],
        ["ADM-08", "Laporan", "Valid", "Lihat Laporan Cabang Sendiri", "1. Ke menu Laporan\n2. Export", "Hanya menampilkan transaksi dari cabangnya sendiri", "", ""]
    ],
    "ROLE: KARYAWAN / KASIR (Aplikasi Mobile POS)" => [
        ["KAS-01", "Autentikasi POS", "Valid", "Login Aplikasi Mobile", "1. Buka Aplikasi HP\n2. Input email & password Karyawan\n3. Login", "Mengarahkan ke halaman Beranda / POS", "", ""],
        ["KAS-02", "Shift Kasir", "Valid", "Buka Shift Baru", "1. Muncul prompt Buka Shift\n2. Input uang modal (Saldo Awal Laci)\n3. Buka Shift", "Aplikasi siap digunakan untuk transaksi", "", ""],
        ["KAS-03", "Shift Kasir", "Invalid", "Akses POS Tanpa Buka Shift", "1. Bypass halaman shift ke menu POS", "Sistem tidak mengizinkan, dipaksa Buka Shift dulu", "", ""],
        ["KAS-04", "Transaksi POS", "Valid", "Checkout Produk Fisik", "1. Pilih Produk Fisik\n2. Tambah Keranjang\n3. Lanjut Pembayaran", "Checkout sukses, invoice muncul, stok fisik berkurang", "", ""],
        ["KAS-05", "Transaksi POS", "Valid", "Checkout Produk Digital", "1. Pilih Produk Digital (Pulsa)\n2. Tambah Keranjang\n3. Bayar", "Checkout sukses, stok fisik tidak terpotong", "", ""],
        ["KAS-06", "Transaksi POS", "Invalid", "Checkout Stok Kosong", "1. Pilih produk dengan stok 0\n2. Tambah ke keranjang", "Muncul error toast 'Stok tidak mencukupi'", "", ""],
        ["KAS-07", "Kas Keluar Mobile", "Valid", "Input Kas Keluar Laci", "1. Ke menu Kas Keluar di HP\n2. Input Nominal & Keterangan\n3. Simpan", "Uang di sistem laci berkurang sejumlah nominal", "", ""],
        ["KAS-08", "Shift Kasir", "Valid", "Tutup Shift (Balance)", "1. Klik Tutup Shift\n2. Input jumlah fisik uang = saldo sistem\n3. Tutup Shift", "Shift berhasil ditutup dengan status selisih 0", "", ""],
        ["KAS-09", "Shift Kasir", "Invalid", "Tutup Shift (Selisih Kurang)", "1. Input fisik uang lebih kecil dari saldo sistem\n2. Tutup Shift", "Shift tertutup tapi tercatat 'Selisih Minus' di web", "", ""]
    ]
];

$xml = '<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Top" ss:WrapText="1"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="sHeader">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1"/>
   <Interior ss:Color="#00466A" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sTitle">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="14" ss:Color="#FFFFFF" ss:Bold="1"/>
   <Interior ss:Color="#D84B20" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sCell">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
   </Borders>
  </Style>
  <Style ss:ID="sCellValid">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
   </Borders>
   <Font ss:FontName="Calibri" ss:Size="11" ss:Color="#006100" ss:Bold="1"/>
   <Interior ss:Color="#C6EFCE" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sCellInvalid">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
   </Borders>
   <Font ss:FontName="Calibri" ss:Size="11" ss:Color="#9C0006" ss:Bold="1"/>
   <Interior ss:Color="#FFC7CE" ss:Pattern="Solid"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Test Cases Role">
  <Table>
   <Column ss:Width="80"/>
   <Column ss:Width="120"/>
   <Column ss:Width="70"/>
   <Column ss:Width="180"/>
   <Column ss:Width="200"/>
   <Column ss:Width="200"/>
   <Column ss:Width="100"/>
   <Column ss:Width="80"/>
';

foreach ($roles_data as $roleName => $rows) {
    // Add title row for this Role
    $xml .= "   <Row ss:Height=\"25\">\n";
    $xml .= "    <Cell ss:MergeAcross=\"7\" ss:StyleID=\"sTitle\"><Data ss:Type=\"String\">" . htmlspecialchars($roleName, ENT_XML1, "UTF-8") . "</Data></Cell>\n";
    $xml .= "   </Row>\n";

    // Add Header row
    $xml .= "   <Row ss:Height=\"20\">\n";
    foreach ($columns as $col) {
        $xml .= "    <Cell ss:StyleID=\"sHeader\"><Data ss:Type=\"String\">" . htmlspecialchars($col, ENT_XML1, "UTF-8") . "</Data></Cell>\n";
    }
    $xml .= "   </Row>\n";

    // Add data rows
    foreach ($rows as $row) {
        $xml .= "   <Row>\n";
        foreach ($row as $colIndex => $cellData) {
            $styleId = "sCell";
            if ($colIndex === 2) { // Jenis Uji
                if (strtoupper($cellData) === 'VALID') $styleId = "sCellValid";
                if (strtoupper($cellData) === 'INVALID') $styleId = "sCellInvalid";
            }
            
            // Escape cell data
            $cellData = htmlspecialchars($cellData, ENT_XML1, "UTF-8");
            // Convert newline to excel newline char
            $cellData = str_replace("\n", "&#10;", $cellData);
            
            $xml .= "    <Cell ss:StyleID=\"{$styleId}\"><Data ss:Type=\"String\">{$cellData}</Data></Cell>\n";
        }
        $xml .= "   </Row>\n";
    }
    
    // Add empty row as separator
    $xml .= "   <Row/>\n";
    $xml .= "   <Row/>\n";
}

$xml .= "  </Table>\n";
$xml .= " </Worksheet>\n";
$xml .= "</Workbook>";

file_put_contents($filename, $xml);
echo "Berhasil membuat file Excel (Test Case Per Role): " . $filename . "\n";
?>
