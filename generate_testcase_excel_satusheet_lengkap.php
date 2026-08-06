<?php
// Script untuk men-generate Test Case Blackbox yang Dikelompokkan Berdasarkan FITUR (Satu Sheet Banyak Tabel)
// Super Lengkap dengan semua Skenario Uji dan Role

$filename = "C:\\Users\\AThariz\\.gemini\\antigravity-ide\\brain\\5fd1bcfd-077a-4e03-bb50-7a8890669438\\Test_Case_Blackbox_Rsix_SatuSheet_Lengkap.xls";

$columns = ["ID Skenario", "Role Terlibat", "Jenis Uji", "Deskripsi Pengujian", "Langkah-Langkah (Skenario)", "Hasil yang Diharapkan", "Hasil Aktual", "Status"];

$features = [
    "Modul: Autentikasi (Web & Mobile)" => [
        ["AUTH-01", "Super, Admin Cabang", "Valid", "Login dengan Kredensial Valid di Web", "1. Buka halaman login web\n2. Input email & password yang benar\n3. Klik Login", "Sistem mengarahkan pengguna ke halaman Dashboard Web sesuai role"],
        ["AUTH-02", "Semua Role", "Invalid", "Login dengan Email Salah", "1. Buka halaman login\n2. Input email salah & password benar\n3. Klik Login", "Muncul pesan error kredensial tidak cocok, login ditolak"],
        ["AUTH-03", "Semua Role", "Invalid", "Login dengan Password Salah", "1. Buka halaman login\n2. Input email benar & password salah\n3. Klik Login", "Muncul pesan error kredensial tidak cocok, login ditolak"],
        ["AUTH-04", "Semua Role", "Invalid", "Login dengan Field Kosong", "1. Biarkan email dan password kosong\n2. Klik Login", "Sistem memunculkan validasi wajib diisi pada field (HTML Required)"],
        ["AUTH-05", "Semua Role", "Invalid", "Login menggunakan Akun Non-aktif", "1. Input email akun dengan status 'Non-aktif'\n2. Klik Login", "Muncul pesan akun telah dinonaktifkan, silakan hubungi admin"],
        ["AUTH-06", "Karyawan (Kasir)", "Valid", "Login dengan Akun Kasir di Aplikasi Mobile", "1. Buka aplikasi POS Mobile\n2. Input email & password Karyawan\n3. Tap Login", "Login sukses, diarahkan ke halaman Buka Shift / Beranda Mobile"],
        ["AUTH-07", "Super, Admin Cabang", "Invalid", "Login ke Mobile menggunakan akun Web", "1. Buka aplikasi POS Mobile\n2. Input email akun Super Admin\n3. Tap Login", "Sistem menolak karena mobile POS hanya untuk role 'karyawan' (opsional jika divalidasi)"],
        ["AUTH-08", "Semua Role", "Valid", "Logout dari Sistem", "1. Klik profil/menu\n2. Pilih Logout", "Sesi terhapus, diarahkan kembali ke halaman Login"]
    ],
    "Modul: Manajemen Cabang" => [
        ["CAB-01", "Super Admin", "Valid", "Tambah Cabang Baru", "1. Ke menu Master Cabang\n2. Klik Tambah\n3. Isi Nama, Alamat, No Telp\n4. Simpan", "Data cabang baru berhasil tersimpan ke database dan muncul di tabel"],
        ["CAB-02", "Super Admin", "Invalid", "Tambah Cabang Field Nama Kosong", "1. Buka form Tambah Cabang\n2. Kosongkan field 'Nama Cabang'\n3. Simpan", "Validasi error 'Nama Cabang wajib diisi'"],
        ["CAB-03", "Super Admin", "Valid", "Edit Data Cabang", "1. Klik Edit pada tabel cabang\n2. Ubah alamat cabang\n3. Simpan", "Data alamat cabang berhasil diperbarui"],
        ["CAB-04", "Super Admin", "Valid", "Toggle Status Aktif/Non-aktif Cabang", "1. Klik tombol Aktif/Nonaktif pada baris cabang\n2. Konfirmasi", "Status cabang berubah (Karyawan di cabang tsb tidak bisa login jika nonaktif)"],
        ["CAB-05", "Admin Cabang", "Invalid", "Akses URL Cabang (Bypass URL)", "1. Login sebagai Admin Cabang\n2. Ketik URL /cabang di browser", "Sistem menolak akses dengan error 403 / Redirect (Akses ditolak)"]
    ],
    "Modul: Manajemen Pengguna" => [
        ["USR-01", "Super Admin", "Valid", "Tambah Akun Super Admin Baru", "1. Ke menu Pengguna\n2. Isi form, Pilih Role: Super, Pilih Cabang: Semua\n3. Simpan", "Akun berhasil dibuat dan bisa login ke web dengan hak penuh"],
        ["USR-02", "Super Admin", "Valid", "Tambah Akun Karyawan / Kasir", "1. Ke menu Pengguna\n2. Isi form, Pilih Role: Karyawan, Pilih Cabang Spesifik\n3. Simpan", "Akun kasir berhasil dibuat untuk cabang tersebut"],
        ["USR-03", "Super Admin", "Invalid", "Tambah Pengguna Email Duplikat", "1. Input form pengguna dengan email yang sudah terdaftar\n2. Simpan", "Sistem memunculkan validasi 'Email sudah digunakan'"],
        ["USR-04", "Super Admin", "Valid", "Edit Password Pengguna", "1. Klik Edit Pengguna\n2. Kosongkan field password jika tidak ingin ubah, isi jika ingin ubah\n3. Simpan", "Password berhasil diubah, atau tetap sama jika dikosongkan"],
        ["USR-05", "Admin Cabang", "Invalid", "Akses Menu Pengguna", "1. Cari menu Pengguna di Sidebar (Seharusnya tidak ada)\n2. Ketik manual URL /pengguna", "Menu tidak tampil, akses manual diblokir"]
    ],
    "Modul: Master Data (Kategori & Master Shift)" => [
        ["MST-01", "Super Admin", "Valid", "Tambah Master Kategori", "1. Ke Menu Kategori\n2. Klik Tambah\n3. Isi nama 'Aksesoris'\n4. Simpan", "Kategori Aksesoris tersimpan dan tampil"],
        ["MST-02", "Super Admin", "Invalid", "Tambah Kategori Tanpa Nama", "1. Buka Tambah Kategori\n2. Biarkan kosong\n3. Simpan", "Sistem menampilkan validasi field required"],
        ["MST-03", "Super Admin", "Valid", "Tambah Master Shift", "1. Ke Menu Master Shift\n2. Input shift 'Pagi', Jam Mulai, Jam Selesai\n3. Simpan", "Data Master Shift tersimpan"],
        ["MST-04", "Super Admin", "Valid", "Edit dan Hapus Kategori", "1. Klik Edit lalu simpan, Klik Hapus pada Kategori yang tidak terpakai", "Data berhasil diedit dan dihapus (jika tak merelasi ke produk)"]
    ],
    "Modul: Manajemen Produk" => [
        ["PRD-01", "Super Admin, Admin Cabang", "Valid", "Tambah Produk Fisik", "1. Ke Menu Produk\n2. Isi Form (Nama, Harga Beli, Harga Jual, SKU, Kategori fisik)\n3. Simpan", "Produk fisik berhasil tersimpan ke sistem"],
        ["PRD-02", "Super Admin, Admin Cabang", "Valid", "Tambah Produk Digital/Manual", "1. Ke Menu Produk\n2. Isi Form\n3. Pilih Kategori dengan nama mengandung 'Pulsa/Data/Manual'\n4. Simpan", "Sistem menandai produk tersebut sebagai produk digital (tampil icon HP)"],
        ["PRD-03", "Super Admin, Admin Cabang", "Invalid", "Tambah Produk Harga Jual Kosong", "1. Isi Form Produk tanpa mengisi Harga Jual\n2. Simpan", "Pesan validasi error 'Harga jual wajib diisi'"],
        ["PRD-04", "Super Admin, Admin Cabang", "Valid", "Edit Harga Produk", "1. Edit Produk\n2. Ubah Nominal Harga Jual\n3. Simpan", "Harga jual produk ter-update, akan berdampak pada transaksi POS berikutnya"],
        ["PRD-05", "Super Admin, Admin Cabang", "Valid", "Cetak Barcode Produk Fisik", "1. Checklist produk fisik\n2. Klik Cetak Barcode Massal", "Membuka tab baru berisi tampilan barcode produk untuk dicetak"],
        ["PRD-06", "Super Admin, Admin Cabang", "Invalid", "Cetak Barcode Produk Digital", "1. Buka tabel produk digital (Filter tipe=manual)\n2. Cek tombol cetak barcode", "Tombol cetak barcode untuk produk digital tidak ditampilkan/di-disable"]
    ],
    "Modul: Manajemen Stok (Masuk, Pindah, Opname)" => [
        ["STK-01", "Super Admin, Admin Cabang", "Valid", "Input Stok Masuk Cabang Sendiri", "1. Ke Stok Masuk\n2. Pilih Produk dan QTY=50\n3. Simpan", "Stok produk bertambah 50 di cabang tersebut"],
        ["STK-02", "Super Admin", "Valid", "Pindah Stok Antar Cabang", "1. Buka Pindah Stok\n2. Cabang Asal A, Tujuan B, QTY=10\n3. Simpan", "Stok cabang A berkurang 10, ada pengajuan barang ke cabang B"],
        ["STK-03", "Super Admin, Admin Cabang", "Invalid", "Stok Masuk QTY Minus", "1. Isi QTY Stok Masuk = -5\n2. Simpan", "Sistem menolak, menampilkan validasi 'Jumlah minimal 1'"],
        ["STK-04", "Admin Cabang", "Invalid", "Pindah Stok Melebihi Ketersediaan", "1. Pindah stok 100 padahal sisa stok hanya 5\n2. Simpan", "Sistem menolak dan memunculkan notifikasi 'Stok tidak mencukupi'"],
        ["STK-05", "Admin Cabang", "Valid", "Ajukan Stok Opname", "1. Ke Stok Opname\n2. Input Fisik=15 padahal Sistem=20 (Selisih -5)\n3. Ajukan", "Pengajuan berhasil dibuat (Status: Pending) stok belum berubah"],
        ["STK-06", "Super Admin", "Valid", "Approve Stok Opname", "1. Login Super Admin\n2. Ke Stok Opname\n3. Klik Approve pada pengajuan cabang", "Stok di sistem otomatis berubah menyesuaikan selisih (menjadi 15)"]
    ],
    "Modul: Shift Kasir (Mobile POS)" => [
        ["SHF-01", "Karyawan (Kasir)", "Invalid", "Akses POS Tanpa Buka Shift", "1. Paksa pindah tab POS di HP saat belum ada shift aktif", "Sistem memblokir dan mengarahkan kembali ke form Buka Shift"],
        ["SHF-02", "Karyawan (Kasir)", "Valid", "Buka Shift dengan Modal Awal", "1. Di halaman Buka Shift\n2. Input Uang Saldo Laci Rp 100.000\n3. Tap Buka Shift", "Shift berstatus Aktif, Kasir bisa melakukan transaksi"],
        ["SHF-03", "Karyawan (Kasir)", "Valid", "Buka Shift Modal 0", "1. Biarkan field Modal Awal kosong / Rp 0\n2. Tap Buka Shift", "Shift berhasil dibuka dengan saldo laci 0"],
        ["SHF-04", "Karyawan (Kasir)", "Valid", "Input Kas Keluar Mobile", "1. Masuk tab Kas Keluar\n2. Input Nominal Rp 50.000, Ket: 'Makan'\n3. Simpan", "Uang Kas Keluar tercatat, mengurangi kalkulasi akhir saldo laci sistem"],
        ["SHF-05", "Karyawan (Kasir)", "Valid", "Tutup Shift Saldo Pas (Balance)", "1. Cek saldo sistem (misal Rp 150.000)\n2. Input saldo fisik Rp 150.000\n3. Tutup Shift", "Shift tertutup, tertulis status 'Selisih Rp 0' (Balance)"],
        ["SHF-06", "Karyawan (Kasir)", "Invalid", "Tutup Shift Saldo Kurang", "1. Sistem laci Rp 150.000\n2. Kasir input fisik Rp 100.000\n3. Tutup", "Shift ditutup namun tercatat 'Selisih Minus Rp 50.000' pada Riwayat Shift"]
    ],
    "Modul: Transaksi Penjualan / Checkout (Mobile POS)" => [
        ["POS-01", "Karyawan (Kasir)", "Valid", "Penjualan Produk Fisik Skenario Sukses", "1. Pilih Produk Fisik (Stok ada)\n2. Add to Cart\n3. Pay (Uang Pas)\n4. Submit", "Transaksi sukses, struk tampil, stok fisik di backend berkurang sesuai qty dibeli"],
        ["POS-02", "Karyawan (Kasir)", "Invalid", "Penjualan Produk Fisik Stok Habis", "1. Pilih Produk Fisik (Stok 0)\n2. Add to Cart", "Muncul toast 'Stok tidak mencukupi', item gagal masuk keranjang"],
        ["POS-03", "Karyawan (Kasir)", "Valid", "Penjualan Produk Digital (Pulsa)", "1. Pindah tab Produk Manual\n2. Tap produk pulsa\n3. Isi Nominal, Nomor HP\n4. Add to Cart -> Bayar", "Transaksi sukses, nomor HP tercatat, STOK produk digital TIDAK dikurangi"],
        ["POS-04", "Karyawan (Kasir)", "Valid", "Kalkulasi Kembalian Otomatis", "1. Total belanja Rp 35.000\n2. Input Uang Pelanggan Rp 50.000", "Sistem memunculkan informasi 'Kembalian Rp 15.000' sebelum dan sesudah checkout"],
        ["POS-05", "Karyawan (Kasir)", "Invalid", "Bayar Dengan Uang Kurang", "1. Total belanja Rp 100.000\n2. Input Uang Pelanggan Rp 90.000\n3. Bayar", "Tombol ter-disable atau sistem menampilkan peringatan 'Uang bayar tidak cukup'"]
    ],
    "Modul: Laporan Penjualan & Dashboard" => [
        ["REP-01", "Super Admin", "Valid", "Filter Laporan Penjualan Antar Cabang", "1. Ke Menu Laporan Penjualan\n2. Pilih Filter: Cabang B\n3. Klik Filter", "Tabel laporan menampilkan penjualan khusus dari Cabang B saja"],
        ["REP-02", "Admin Cabang", "Invalid", "Melihat Laporan Cabang Lain", "1. Login sebagai Admin Cabang\n2. Buka menu Laporan\n3. Cek dropdown filter cabang", "Filter cabang terkunci atau hanya menampilkan opsi cabangnya sendiri"],
        ["REP-03", "Super Admin, Admin Cabang", "Valid", "Filter Berdasarkan Tanggal", "1. Buka menu Laporan\n2. Set Tanggal Mulai dan Akhir ke bulan lalu\n3. Terapkan", "Laporan ter-update menampilkan penjualan hanya di rentang waktu tersebut"],
        ["REP-04", "Super Admin, Admin Cabang", "Valid", "Export / Unduh Laporan", "1. Buka halaman Laporan\n2. Klik Download Excel/PDF", "Terunduh file laporan yang isinya sesuai dengan parameter filter yang aktif"],
        ["REP-05", "Super Admin, Admin Cabang", "Valid", "Data Dashboard Realtime", "1. Cek Omzet di Dashboard\n2. Kasir lakukan 1 transaksi baru\n3. Refresh Dashboard", "Angka total omzet dan transaksi hari ini bertambah sesuai transaksi terakhir"]
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
 <Worksheet ss:Name="Test Cases Blackbox">
  <Table>
   <Column ss:Width="80"/>
   <Column ss:Width="120"/>
   <Column ss:Width="70"/>
   <Column ss:Width="180"/>
   <Column ss:Width="220"/>
   <Column ss:Width="220"/>
   <Column ss:Width="100"/>
   <Column ss:Width="80"/>
';

foreach ($features as $featureName => $rows) {
    // Add title row for this Feature
    $xml .= "   <Row ss:Height=\"25\">\n";
    $xml .= "    <Cell ss:MergeAcross=\"7\" ss:StyleID=\"sTitle\"><Data ss:Type=\"String\">" . htmlspecialchars($featureName, ENT_XML1, "UTF-8") . "</Data></Cell>\n";
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
echo "Berhasil membuat file Excel (Test Case Satu Sheet Super Lengkap): " . $filename . "\n";
?>
