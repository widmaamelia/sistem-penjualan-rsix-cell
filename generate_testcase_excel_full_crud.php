<?php
// Script untuk men-generate Test Case Blackbox Excel (.xls) Lengkap dengan Skenario CRUD Penuh
// Berdasarkan data Word terakhir
$filename = "C:\\Users\\AThariz\\.gemini\\antigravity-ide\\brain\\5fd1bcfd-077a-4e03-bb50-7a8890669438\\Test_Case_Blackbox_Rsix_Full_CRUD.xls";

$columns = ["ID TC", "Role / Aktor", "Skenario Uji (CRUD)", "Precondition", "Langkah Pengujian", "Data Uji", "Hasil Diharapkan", "Status"];

$features = [
    "Pengujian Modul: Autentikasi (Web & Mobile)" => [
        ["TC-AUTH-01", "Semua Role", "Login Kredensial Valid", "Berada di form Login", "1. Input email & password benar\n2. Klik Login", "Email & Password valid", "Diarahkan ke Dashboard / Beranda sesuai hak akses", ""],
        ["TC-AUTH-02", "Semua Role", "Login Field Kosong", "Berada di form Login", "1. Biarkan email / password kosong\n2. Klik Login", "Email: Kosong", "Muncul pesan validasi 'Field wajib diisi'", ""],
        ["TC-AUTH-03", "Semua Role", "Login Kredensial Salah", "Berada di form Login", "1. Input password salah\n2. Klik Login", "Password Salah", "Sistem menampilkan pesan 'Kredensial tidak cocok'", ""],
        ["TC-AUTH-04", "Semua Role", "Logout (Keluar Sesi)", "Berada di Dashboard", "1. Klik profil\n2. Klik Logout", "-", "Sesi berakhir, sistem mengarahkan kembali ke halaman Login", ""]
    ],

    "Pengujian Modul: Master Cabang (Web)" => [
        ["TC-CAB-01", "Super Admin", "[Create] Tambah Cabang Valid", "Berada di menu Tambah Cabang", "1. Input nama dan alamat cabang\n2. Simpan", "Nama: Cabang A\nAlamat: Jl. X", "Data cabang tersimpan ke database", ""],
        ["TC-CAB-02", "Super Admin", "[Create] Tambah Cabang Invalid", "Berada di menu Tambah Cabang", "1. Kosongkan field nama cabang\n2. Simpan", "Nama: Kosong", "Muncul pesan validasi form wajib diisi", ""],
        ["TC-CAB-03", "Super Admin", "[Read] Menampilkan Daftar Cabang", "Berada di menu Cabang", "1. Buka menu cabang", "-", "Tabel menampilkan seluruh data cabang secara lengkap", ""],
        ["TC-CAB-04", "Super Admin", "[Update] Edit Data Cabang", "Berada di menu Cabang", "1. Klik tombol Edit\n2. Ubah Alamat\n3. Simpan", "Alamat Baru: Jl. Y", "Perubahan alamat tersimpan", ""],
        ["TC-CAB-05", "Super Admin", "[Delete] Ubah Status Cabang", "Berada di menu Cabang", "1. Klik Aktif/Nonaktif", "-", "Status berubah, karyawan cabang nonaktif tidak bisa login", ""]
    ],

    "Pengujian Modul: Manajemen Pengguna (Web)" => [
        ["TC-USR-01", "Super Admin", "[Create] Tambah Karyawan Valid", "Berada di Tambah Pengguna", "1. Input Nama, Email\n2. Pilih Role: Karyawan\n3. Simpan", "Role: Karyawan", "Akun tersimpan dan bisa digunakan di aplikasi mobile", ""],
        ["TC-USR-02", "Super Admin", "[Create] Tambah Email Duplikat", "Berada di Tambah Pengguna", "1. Input email yang sudah ada di database\n2. Simpan", "Email: sama@rsix.com", "Muncul error 'Email sudah digunakan'", ""],
        ["TC-USR-03", "Super Admin", "[Read] Tampil Data Pengguna", "Berada di menu Pengguna", "1. Buka halaman pengguna", "-", "Tabel menampilkan seluruh pengguna beserta status rolenya", ""],
        ["TC-USR-04", "Super Admin", "[Update] Ubah Password/Nama", "Berada di menu Edit Pengguna", "1. Input password baru\n2. Simpan", "Pass: 54321", "Data terupdate, user bisa login menggunakan pass baru", ""],
        ["TC-USR-05", "Super Admin", "[Delete] Nonaktifkan Pengguna", "Berada di menu Pengguna", "1. Klik Aktif/Nonaktif", "-", "Akun tidak bisa login ketika statusnya nonaktif", ""]
    ],

    "Pengujian Modul: Master Kategori (Web)" => [
        ["TC-KAT-01", "Super Admin", "[Create] Tambah Kategori", "Berada di menu Kategori", "1. Input nama kategori\n2. Simpan", "Nama: Aksesoris", "Data kategori tersimpan", ""],
        ["TC-KAT-02", "Super Admin", "[Read] Tampil Data Kategori", "Berada di menu Kategori", "1. Akses menu kategori", "-", "Tabel menampilkan semua kategori", ""],
        ["TC-KAT-03", "Super Admin", "[Update] Edit Kategori", "Berada di menu Kategori", "1. Klik Edit\n2. Ubah nama\n3. Simpan", "Nama: Aksesoris HP", "Nama kategori terupdate di database", ""],
        ["TC-KAT-04", "Super Admin", "[Delete] Hapus Kategori", "Berada di menu Kategori", "1. Klik Hapus\n2. Konfirmasi 'Yes'", "-", "Kategori terhapus dari sistem (jika belum dipakai produk)", ""]
    ],

    "Pengujian Modul: Master Shift (Web)" => [
        ["TC-MSF-01", "Super Admin", "[Create] Tambah Master Shift", "Berada di menu Master Shift", "1. Input nama, jam mulai, jam selesai\n2. Simpan", "Shift Pagi: 08:00 - 15:00", "Master shift berhasil ditambahkan", ""],
        ["TC-MSF-02", "Super Admin", "[Read] Tampil Data Master Shift", "Berada di menu Master Shift", "1. Akses halaman", "-", "Menampilkan daftar master shift", ""],
        ["TC-MSF-03", "Super Admin", "[Update] Edit Master Shift", "Berada di menu Master Shift", "1. Ubah jam selesai shift\n2. Simpan", "Jam Selesai: 16:00", "Data jam master shift terupdate", ""],
        ["TC-MSF-04", "Super Admin", "[Delete] Hapus Master Shift", "Berada di menu Master Shift", "1. Klik Hapus\n2. Konfirmasi", "-", "Master shift terhapus", ""]
    ],

    "Pengujian Modul: Jadwal Shift Karyawan (Web)" => [
        ["TC-JSF-01", "Super/Admin Cabang", "[Create] Plotting Jadwal Baru", "Berada di Jadwal Shift", "1. Pilih Kasir\n2. Pilih Tanggal & Master Shift\n3. Simpan", "Tgl: 25 Okt", "Jadwal shift berhasil diplot untuk kasir tersebut", ""],
        ["TC-JSF-02", "Super/Admin Cabang", "[Read] Tampil Jadwal", "Berada di Jadwal Shift", "1. Akses halaman jadwal", "-", "Tabel memunculkan daftar plot jadwal karyawan", ""],
        ["TC-JSF-03", "Super/Admin Cabang", "[Update] Set Status Izin", "Berada di Jadwal Shift", "1. Klik Set Izin pada baris jadwal\n2. Konfirmasi", "-", "Status shift berubah dari aktif menjadi 'Izin'", ""],
        ["TC-JSF-04", "Super/Admin Cabang", "[Delete] Batal/Hapus Jadwal", "Berada di Jadwal Shift", "1. Klik Hapus pada jadwal yang belum berjalan", "-", "Jadwal shift tersebut terhapus dari kalender", ""]
    ],

    "Pengujian Modul: Manajemen Produk (Web)" => [
        ["TC-PRD-01", "Super/Admin Cabang", "[Create] Tambah Produk Fisik", "Berada di form Tambah Produk", "1. Input nama, sku, harga beli, jual\n2. Kategori: Fisik\n3. Simpan", "Harga: 50.000\nTipe: Fisik", "Tersimpan sebagai barang fisik (akan perlu print barcode)", ""],
        ["TC-PRD-02", "Super/Admin Cabang", "[Create] Tambah Produk Manual/Digital", "Berada di form Tambah Produk", "1. Input data\n2. Kategori: Pulsa\n3. Simpan", "Tipe: Digital", "Tersimpan sebagai barang digital (icon HP), barcode disable", ""],
        ["TC-PRD-03", "Super/Admin Cabang", "[Read] Tampil & Filter Produk", "Berada di menu Produk", "1. Klik toggle Produk Manual", "-", "Tabel berhasil memfilter khusus barang fisik atau digital", ""],
        ["TC-PRD-04", "Super/Admin Cabang", "[Update] Edit Harga Produk", "Berada di menu Edit Produk", "1. Ubah nominal harga jual\n2. Simpan", "Harga Baru: 55.000", "Harga terupdate, tersinkron langsung ke POS", ""],
        ["TC-PRD-05", "Super/Admin Cabang", "[Delete] Hapus Produk", "Berada di menu Produk", "1. Klik Hapus pada produk uji coba", "-", "Produk terhapus (jika belum pernah ada transaksi)", ""],
        ["TC-PRD-06", "Super/Admin Cabang", "Cetak Barcode Massal", "Ada produk fisik", "1. Centang beberapa produk\n2. Klik Cetak Barcode", "-", "Pop up / Tab PDF memuat gambar barcode barang", ""]
    ],

    "Pengujian Modul: Manajemen Stok (Web)" => [
        ["TC-STK-01", "Super/Admin Cabang", "[Create] Input Stok Masuk", "Menu Stok Masuk", "1. Pilih Produk\n2. Input QTY: 20\n3. Simpan", "QTY: 20", "Stok fisik di sistem bertambah", ""],
        ["TC-STK-02", "Super Admin", "[Create] Input Pindah Stok", "Menu Pindah Stok", "1. Pilih Cabang Asal, Tujuan\n2. Input QTY\n3. Simpan", "QTY: 10", "Stok asal berkurang, masuk antrean cabang tujuan", ""],
        ["TC-STK-03", "Super/Admin Cabang", "[Read] Riwayat Pergerakan Stok", "Menu Stok", "1. Klik tombol History Stok pada barang", "-", "Muncul log keluar masuknya stok beserta keterangan", ""]
    ],

    "Pengujian Modul: Stok Opname (Web)" => [
        ["TC-OPN-01", "Admin Cabang", "[Create] Buat Ajuan Opname", "Menu Stok Opname", "1. Cek stok sistem\n2. Input stok fisik\n3. Simpan", "Sistem: 20\nFisik: 15", "Tersimpan dengan status Pending (Selisih -5)", ""],
        ["TC-OPN-02", "Super Admin", "[Read] Cek Ajuan Opname", "Menu Stok Opname", "1. Login Super Admin\n2. Buka menu Opname", "-", "Melihat ajuan opname dari admin cabang", ""],
        ["TC-OPN-03", "Super Admin", "[Update] Approve Opname", "Menu Stok Opname", "1. Klik tombol Approve\n2. Konfirmasi", "-", "Status menjadi Approved, stok sistem menyesuaikan fisik", ""]
    ],
    
    "Pengujian Modul: Kas Keluar (Web & Mobile)" => [
        ["TC-KAS-01", "Karyawan / Admin", "[Create] Input Kas Keluar", "Menu Kas Keluar", "1. Input Nominal & Keterangan\n2. Simpan", "Nominal: 50.000", "Data pengeluaran tercatat memotong kas berjalan", ""],
        ["TC-KAS-02", "Karyawan / Admin", "[Read] Tampil Riwayat Kas", "Menu Kas Keluar", "1. Buka menu", "-", "Menampilkan log seluruh pengeluaran kasir", ""],
        ["TC-KAS-03", "Super Admin", "[Delete] Hapus Kas Keluar", "Menu Kas Keluar Web", "1. Klik tombol Hapus pada record", "-", "Pengeluaran terhapus, saldo kas dikembalikan seperti semula", ""]
    ],

    "Pengujian Modul: Shift POS (Aplikasi Mobile)" => [
        ["TC-SHF-01", "Karyawan (Kasir)", "[Create] Buka Shift (Modal)", "Layar Buka Shift", "1. Input uang laci\n2. Tap Buka Shift", "Modal: 100k", "Shift aktif, kasir masuk ke Beranda", ""],
        ["TC-SHF-02", "Karyawan (Kasir)", "[Read] Cek Dashboard & Riwayat", "Layar Beranda & Riwayat", "1. Lihat Omzet & tab Riwayat Shift", "-", "Menampilkan ringkasan data shift yang sedang jalan", ""],
        ["TC-SHF-03", "Karyawan (Kasir)", "[Update] Tutup Shift (Balance/Minus)", "Layar Tutup Shift", "1. Input jumlah fisik di laci\n2. Tap Tutup Shift", "-", "Shift tertutup, kalkulasi selisih dihitung dan dilaporkan", ""]
    ],

    "Pengujian Modul: Transaksi POS (Aplikasi Mobile)" => [
        ["TC-POS-01", "Karyawan (Kasir)", "[Create] Tambah Keranjang", "Layar Transaksi", "1. Tap produk fisik / digital", "Produk A", "Produk masuk ke keranjang beserta harga", ""],
        ["TC-POS-02", "Karyawan (Kasir)", "[Read] Hitung Total & Kembalian", "Layar Keranjang", "1. Input nominal uang pelanggan (Bayar)", "Total: 50k\nBayar: 100k", "Sistem menampilkan 'Kembalian Rp 50.000'", ""],
        ["TC-POS-03", "Karyawan (Kasir)", "[Create] Proses Checkout (Submit)", "Layar Pembayaran", "1. Tap Bayar / Selesai", "-", "Transaksi sukses, stok terpotong (jika fisik), generate invoice", ""],
        ["TC-POS-04", "Karyawan (Kasir)", "[Create] Cetak Struk Bluetooth", "Invoice Sukses", "1. Tap icon Print", "-", "Struk tercetak melalui printer thermal Bluetooth terhubung", ""]
    ],

    "Pengujian Modul: Laporan Penjualan (Web)" => [
        ["TC-LAP-01", "Super / Admin", "[Read] Filter Cabang & Tanggal", "Menu Laporan", "1. Set tanggal awal & akhir\n2. Filter Cabang\n3. Terapkan", "Tanggal 1-31", "Tabel memfilter hanya transaksi di rentang dan cabang tsb", ""],
        ["TC-LAP-02", "Super / Admin", "[Create/Export] Unduh PDF/Excel", "Menu Laporan", "1. Klik tombol Download", "-", "Sistem mem-generate file download untuk diarsipkan", ""]
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
   <Interior ss:Color="#0C4631" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sTitle">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="14" ss:Color="#FFFFFF" ss:Bold="1"/>
   <Interior ss:Color="#126848" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="sCell">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D4D4D4"/>
   </Borders>
  </Style>
 </Styles>
 <Worksheet ss:Name="Test Cases Blackbox Full CRUD">
  <Table>
   <Column ss:Width="80"/>
   <Column ss:Width="110"/>
   <Column ss:Width="150"/>
   <Column ss:Width="130"/>
   <Column ss:Width="170"/>
   <Column ss:Width="90"/>
   <Column ss:Width="140"/>
   <Column ss:Width="70"/>
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
echo "Berhasil membuat file Excel Full CRUD (Dari Word Terakhir): " . $filename . "\n";
?>
