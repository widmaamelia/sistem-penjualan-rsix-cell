<?php
// Script untuk men-generate Test Case Blackbox dalam format XML Spreadsheet 2003
// yang mendukung Multiple Sheets, bisa dibuka langsung di Excel (.xls)

$filename = "C:\\Users\\AThariz\\.gemini\\antigravity-ide\\brain\\5fd1bcfd-077a-4e03-bb50-7a8890669438\\Test_Case_Blackbox_Rsix_MultiSheet.xls";

$sheets = [
    "Login & Autentikasi" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["LOG-01", "Login dengan Kredensial Valid (Admin)", "Valid", "1. Masuk ke halaman login\n2. Masukkan email & password benar\n3. Klik Login", "Sistem mengarahkan ke Dashboard Web Admin", ""],
        ["LOG-02", "Login dengan Email Salah", "Invalid", "1. Masuk ke halaman login\n2. Masukkan email salah & password benar\n3. Klik Login", "Sistem menolak dan menampilkan pesan error 'Email/Password salah'", ""],
        ["LOG-03", "Login dengan Password Salah", "Invalid", "1. Masuk ke halaman login\n2. Masukkan email benar & password salah\n3. Klik Login", "Sistem menolak dan menampilkan pesan error 'Email/Password salah'", ""],
        ["LOG-04", "Login dengan Kredensial Valid (Kasir Mobile)", "Valid", "1. Buka aplikasi Mobile\n2. Masukkan email & password kasir\n3. Tap Login", "Sistem mengarahkan ke halaman Beranda POS Kasir Mobile", ""],
        ["LOG-05", "Login dengan Akun Non-aktif", "Invalid", "1. Masuk ke halaman login\n2. Masukkan akun yang sudah dinonaktifkan\n3. Klik Login", "Sistem menolak login dan memberitahu status akun", ""],
        ["LOG-06", "Logout dari Sistem", "Valid", "1. Klik profil\n2. Klik Logout", "Sesi terhapus, pengguna kembali ke halaman Login", ""]
    ],
    "Manajemen Kategori" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["KAT-01", "Tambah Kategori Baru", "Valid", "1. Masuk Master Kategori\n2. Klik Tambah\n3. Isi Nama Kategori (misal: 'Charger')\n4. Simpan", "Kategori berhasil tersimpan dan tampil di tabel", ""],
        ["KAT-02", "Tambah Kategori Tanpa Nama", "Invalid", "1. Klik Tambah\n2. Kosongkan form\n3. Simpan", "Validasi error: Nama kategori wajib diisi", ""],
        ["KAT-03", "Edit Nama Kategori", "Valid", "1. Klik tombol Edit pada Kategori\n2. Ubah nama\n3. Simpan", "Perubahan nama kategori berhasil disimpan", ""],
        ["KAT-04", "Hapus Kategori (Tanpa Produk)", "Valid", "1. Klik Hapus pada kategori\n2. Konfirmasi Hapus", "Kategori terhapus dari sistem", ""]
    ],
    "Manajemen Produk" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["PRD-01", "Tambah Produk Fisik", "Valid", "1. Masuk Tambah Produk\n2. Isi Nama, Harga, SKU, Kategori (Fisik)\n3. Simpan", "Produk baru berhasil disimpan ke database dan tampil", ""],
        ["PRD-02", "Tambah Produk Digital (Pulsa)", "Valid", "1. Masuk Tambah Produk\n2. Isi Nama, Harga, Kategori: 'Pulsa'\n3. Simpan", "Produk digital (pulsa) tersimpan dan mendapat badge 'Manual/Digital', tombol cetak barcode nonaktif", ""],
        ["PRD-03", "Tambah Produk Tanpa Harga", "Invalid", "1. Isi Nama\n2. Kosongkan form Harga Jual\n3. Simpan", "Validasi error: Harga Jual wajib diisi", ""],
        ["PRD-04", "Edit Data Produk", "Valid", "1. Klik Edit Produk\n2. Ubah harga jual\n3. Simpan", "Harga jual produk berhasil diperbarui", ""],
        ["PRD-05", "Cari Produk di Web", "Valid", "1. Ketik nama produk di kotak pencarian\n2. Enter", "Tabel hanya menampilkan produk yang sesuai pencarian", ""]
    ],
    "Manajemen Cabang & Pengguna" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["CAB-01", "Tambah Cabang Baru", "Valid", "1. Masuk Manajemen Cabang\n2. Klik Tambah\n3. Isi Nama Cabang & Alamat\n4. Simpan", "Cabang berhasil tersimpan", ""],
        ["USR-01", "Tambah Pengguna/Kasir", "Valid", "1. Masuk Manajemen Pengguna\n2. Isi Data, pilih Role Kasir, pilih Cabang\n3. Simpan", "Akun kasir berhasil dibuat dan bisa login", ""],
        ["USR-02", "Tambah Pengguna Email Duplikat", "Invalid", "1. Masukkan email yang sudah dipakai kasir lain\n2. Simpan", "Validasi error: Email sudah digunakan", ""]
    ],
    "Manajemen Stok" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["STK-01", "Input Stok Masuk Cabang", "Valid", "1. Masuk Stok Masuk\n2. Pilih Produk & Cabang\n3. Isi Jumlah Masuk (10)\n4. Simpan", "Stok produk bertambah 10 pada cabang tersebut", ""],
        ["STK-02", "Input Stok Minus/Negatif", "Invalid", "1. Isi Jumlah Masuk dengan '-5'\n2. Simpan", "Validasi error: Jumlah stok tidak boleh negatif", ""],
        ["STK-03", "Pindah Stok Antar Cabang", "Valid", "1. Masuk Pindah Stok\n2. Pilih Cabang Asal & Tujuan\n3. Isi Produk & QTY\n4. Simpan", "Stok cabang asal berkurang, cabang tujuan bertambah sesuai QTY", ""],
        ["STK-04", "Pindah Stok (Stok Asal Kurang)", "Invalid", "1. Pindah stok 50, padahal sisa stok hanya 10\n2. Simpan", "Sistem menolak dan menampilkan pesan 'Stok tidak mencukupi'", ""]
    ],
    "Shift Kasir" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["SHF-01", "Buka Shift Baru", "Valid", "1. Login Mobile\n2. Masukkan Modal Awal (Saldo Laci)\n3. Tap Buka Shift", "Shift berhasil dibuka, pengguna bisa mulai transaksi", ""],
        ["SHF-02", "Buka Shift Modal Kosong", "Valid", "1. Modal Awal dibiarkan 0\n2. Buka Shift", "Shift dibuka dengan modal awal Rp 0", ""],
        ["SHF-03", "Input Kas Keluar", "Valid", "1. Pilih menu Kas Keluar\n2. Masukkan nominal & keterangan\n3. Simpan", "Uang di sistem laci berkurang dan masuk history pengeluaran", ""],
        ["SHF-04", "Tutup Shift Saldo Klop", "Valid", "1. Masuk form Tutup Shift\n2. Input jumlah uang laci fisik yang sesuai dengan kalkulasi sistem\n3. Tap Tutup Shift", "Shift ditutup dengan keterangan 'Selisih Rp 0' (Balance)", ""],
        ["SHF-05", "Tutup Shift Saldo Kurang", "Invalid", "1. Masuk form Tutup Shift\n2. Input jumlah fisik LEBIH KECIL dari sistem\n3. Tap Tutup Shift", "Sistem tetap menutup shift dan mencatat sebagai 'Selisih Minus / Kurang'", ""]
    ],
    "Transaksi POS Mobile" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["POS-01", "Transaksi Produk Fisik", "Valid", "1. Buka POS Mobile\n2. Tap produk fisik (ex: Charger)\n3. Tap Keranjang\n4. Lanjut Pembayaran", "Checkout berhasil, stok fisik berkurang", ""],
        ["POS-02", "Transaksi Produk Digital", "Valid", "1. Tap tab kategori Pulsa\n2. Tap 'Pulsa 5K'\n3. Masukkan no HP tujuan\n4. Checkout", "Checkout berhasil, stok digital dihiraukan (tidak dipotong)", ""],
        ["POS-03", "Transaksi Produk Stok Kosong", "Invalid", "1. Pilih produk yang stoknya 0\n2. Tambah ke keranjang", "Sistem menolak dan memunculkan toast 'Stok tidak mencukupi'", ""],
        ["POS-04", "Pembayaran Uang Kurang", "Invalid", "1. Total belanja Rp 50.000\n2. Input uang pelanggan Rp 40.000\n3. Bayar", "Validasi error: 'Uang bayar tidak cukup'", ""],
        ["POS-05", "Pembayaran Kembalian", "Valid", "1. Belanja Rp 15.000\n2. Uang pelanggan Rp 20.000\n3. Bayar", "Transaksi berhasil, invoice tercetak, menampilkan kembalian Rp 5.000", ""]
    ],
    "Laporan" => [
        ["ID", "Skenario Uji", "Jenis Uji", "Langkah-langkah", "Ekspektasi Hasil", "Status"],
        ["REP-01", "Filter Laporan Penjualan", "Valid", "1. Masuk Laporan Penjualan Web\n2. Set filter Tgl Awal & Tgl Akhir\n3. Terapkan", "Data yang muncul hanya transaksi dalam rentang tanggal tersebut", ""],
        ["REP-02", "Export Laporan Penjualan", "Valid", "1. Klik tombol Export/Download Laporan\n2. Cek file", "File Excel/PDF terunduh berisi data sesuai filter", ""]
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
   <Interior ss:Color="#4F81BD" ss:Pattern="Solid"/>
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
';

foreach ($sheets as $sheetName => $rows) {
    // Escape sheet name just in case
    $sheetName = htmlspecialchars($sheetName);
    $xml .= " <Worksheet ss:Name=\"{$sheetName}\">\n";
    $xml .= "  <Table>\n";
    
    // Define column widths
    $xml .= '   <Column ss:Width="60"/>'."\n";
    $xml .= '   <Column ss:Width="200"/>'."\n";
    $xml .= '   <Column ss:Width="70"/>'."\n";
    $xml .= '   <Column ss:Width="250"/>'."\n";
    $xml .= '   <Column ss:Width="250"/>'."\n";
    $xml .= '   <Column ss:Width="80"/>'."\n";

    foreach ($rows as $index => $row) {
        $xml .= "   <Row>\n";
        foreach ($row as $colIndex => $cellData) {
            $styleId = "sCell";
            if ($index === 0) {
                $styleId = "sHeader";
            } else {
                if ($colIndex === 2) { // Jenis Uji column
                    if (strtoupper($cellData) === 'VALID') $styleId = "sCellValid";
                    if (strtoupper($cellData) === 'INVALID') $styleId = "sCellInvalid";
                }
            }
            
            // Escape cell data
            $cellData = htmlspecialchars($cellData, ENT_XML1, "UTF-8");
            // Convert newline to excel newline char if needed, XMLSS uses &#10;
            $cellData = str_replace("\n", "&#10;", $cellData);
            
            $xml .= "    <Cell ss:StyleID=\"{$styleId}\"><Data ss:Type=\"String\">{$cellData}</Data></Cell>\n";
        }
        $xml .= "   </Row>\n";
    }
    
    $xml .= "  </Table>\n";
    $xml .= " </Worksheet>\n";
}

$xml .= "</Workbook>";

file_put_contents($filename, $xml);
echo "Berhasil membuat file Excel (XMLSS) dengan Multi-Sheet: " . $filename . "\n";
?>
