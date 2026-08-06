<?php
// Script untuk men-generate Test Case Blackbox SANGAT LENGKAP (Web + Mobile Keseluruhan)
$filename = "C:\\Users\\AThariz\\.gemini\\antigravity-ide\\brain\\5fd1bcfd-077a-4e03-bb50-7a8890669438\\Test_Case_Blackbox_Rsix_Final_Lengkap.xls";

$columns = ["ID Skenario", "Role Terlibat", "Jenis Uji", "Deskripsi Pengujian", "Langkah-Langkah (Skenario)", "Hasil yang Diharapkan", "Hasil Aktual", "Status"];

$features = [
    "Modul: Autentikasi (Web)" => [
        ["AUTH-W-01", "Super, Admin Cabang", "Valid", "Login Kredensial Valid Web", "1. Buka halaman login web\n2. Input email & password\n3. Klik Login", "Diarahkan ke halaman Dashboard sesuai role"],
        ["AUTH-W-02", "Super, Admin Cabang", "Invalid", "Login Email Salah/Kosong", "1. Input email salah atau kosong\n2. Klik Login", "Muncul peringatan kredensial salah / field wajib diisi"],
        ["AUTH-W-03", "Super, Admin Cabang", "Valid", "Logout Web", "1. Klik profil di pojok kanan atas\n2. Klik Logout", "Sesi berakhir, dialihkan ke form Login Web"]
    ],
    "Modul: Dashboard (Web)" => [
        ["DASH-01", "Super Admin", "Valid", "Ringkasan Data Semua Cabang", "1. Buka menu Dashboard\n2. Cek card Omzet, Transaksi, Total Cabang", "Data yang tampil adalah akumulasi dari seluruh cabang"],
        ["DASH-02", "Admin Cabang", "Valid", "Ringkasan Data Cabang Sendiri", "1. Login sebagai Admin Cabang\n2. Buka menu Dashboard", "Data yang tampil hanya data transaksi & kasir di cabangnya sendiri"]
    ],
    "Modul: Master Cabang & Pengguna (Web)" => [
        ["MST-01", "Super Admin", "Valid", "Tambah Cabang", "1. Buka menu Cabang\n2. Input data\n3. Simpan", "Data cabang tersimpan"],
        ["MST-02", "Super Admin", "Valid", "Tambah Pengguna (Super & Karyawan)", "1. Buka menu Pengguna\n2. Input form, pilih role\n3. Simpan", "Akun berhasil dibuat"],
        ["MST-03", "Super Admin", "Valid", "Ubah Status Aktif/Nonaktif", "1. Buka tabel Cabang/Pengguna\n2. Klik tombol Aktif/Non-aktif", "Status berubah, akses akun ditolak jika dinonaktifkan"],
        ["MST-04", "Admin Cabang", "Invalid", "Akses Menu Super Admin", "1. Paksa masuk URL /cabang atau /pengguna via address bar", "Sistem menolak (Akses Ditolak / redirect)"]
    ],
    "Modul: Master Kategori & Shift (Web)" => [
        ["KAS-01", "Super Admin", "Valid", "Manajemen Kategori", "1. Buka menu Kategori\n2. Tambah, Edit, Hapus kategori", "Kategori produk tersimpan, berubah, atau terhapus"],
        ["KAS-02", "Super Admin", "Valid", "Manajemen Master Shift", "1. Buka menu Master Shift\n2. Input nama shift & jam\n3. Simpan", "Jadwal shift utama tersimpan di database"]
    ],
    "Modul: Jadwal Shift Karyawan (Web)" => [
        ["JDW-01", "Super, Admin Cabang", "Valid", "Plotting Jadwal Shift Kasir", "1. Buka menu Jadwal Shift\n2. Pilih karyawan, tanggal, dan master shift\n3. Simpan", "Karyawan memiliki jadwal kerja pada tanggal tersebut"],
        ["JDW-02", "Super, Admin Cabang", "Valid", "Set Izin Karyawan", "1. Buka menu Jadwal Shift\n2. Klik tombol Set Izin pada jadwal tertentu\n3. Simpan", "Status jadwal shift berubah menjadi 'Izin'"]
    ],
    "Modul: Manajemen Produk (Web)" => [
        ["PRD-01", "Super, Admin Cabang", "Valid", "Tambah Produk Fisik", "1. Isi form produk\n2. Pilih kategori fisik\n3. Simpan", "Produk tersimpan di database"],
        ["PRD-02", "Super, Admin Cabang", "Valid", "Tambah Produk Digital/Manual", "1. Isi form produk\n2. Pilih kategori (pulsa/digital)\n3. Simpan", "Tersimpan dengan label digital (icon HP), opsi barcode disembunyikan"],
        ["PRD-03", "Super, Admin Cabang", "Valid", "Edit Produk & Harga", "1. Klik tombol Edit produk\n2. Ubah harga/nama\n3. Simpan", "Perubahan tersimpan, berdampak pada POS Mobile"],
        ["PRD-04", "Super, Admin Cabang", "Valid", "Cetak Barcode Massal", "1. Centang beberapa produk fisik\n2. Klik Cetak Barcode Massal", "PDF/Halaman berisi QR Code/Barcode siap cetak terbuka"]
    ],
    "Modul: Manajemen Stok & Opname (Web)" => [
        ["STK-01", "Super, Admin Cabang", "Valid", "Stok Masuk Cabang", "1. Menu Stok Masuk\n2. Pilih produk & QTY\n3. Simpan", "Stok bertambah di cabang terpilih"],
        ["STK-02", "Super Admin", "Valid", "Pindah Stok Antar Cabang", "1. Menu Pindah Stok\n2. Pilih Cabang Asal & Tujuan\n3. Simpan", "Stok cabang asal berkurang, diajukan ke cabang tujuan"],
        ["STK-03", "Admin Cabang", "Invalid", "Stok Masuk QTY Minus", "1. Input QTY negatif (-10)\n2. Simpan", "Validasi error 'Jumlah stok tidak boleh negatif'"],
        ["STK-04", "Admin Cabang", "Valid", "Pengajuan Stok Opname", "1. Menu Opname\n2. Input jumlah fisik\n3. Simpan", "Opname berstatus 'Pending' menanti approval Super Admin"],
        ["STK-05", "Super Admin", "Valid", "Approve Stok Opname", "1. Menu Opname\n2. Klik Approve pada baris ajuan", "Stok di database tersinkronisasi sesuai selisih opname"]
    ],
    "Modul: Laporan Penjualan (Web)" => [
        ["REP-01", "Super Admin", "Valid", "Filter Laporan Semua Cabang", "1. Buka menu Laporan\n2. Set filter Cabang = 'Semua' dan set Tanggal\n3. Filter", "Menampilkan data rekap seluruh cabang"],
        ["REP-02", "Admin Cabang", "Valid", "Export Laporan Excel/PDF", "1. Buka Laporan (otomatis terfilter cabang sendiri)\n2. Klik Unduh Excel", "File laporan terunduh memuat transaksi cabangnya saja"]
    ],
    "Modul: Autentikasi (Aplikasi Mobile)" => [
        ["MOB-01", "Karyawan (Kasir)", "Valid", "Login Kasir Mobile", "1. Buka Aplikasi POS HP\n2. Input email & password Kasir\n3. Tap Login", "Diarahkan ke tampilan beranda POS Mobile / Buka Shift"],
        ["MOB-02", "Karyawan (Kasir)", "Invalid", "Login Salah Password", "1. Buka Aplikasi\n2. Input password yang salah\n3. Tap Login", "Muncul peringatan (toast/snackbar) 'Email atau password salah'"]
    ],
    "Modul: Buka & Tutup Shift (Aplikasi Mobile)" => [
        ["SHF-M-01", "Karyawan (Kasir)", "Valid", "Buka Shift Modal", "1. Di layar Buka Shift, input Uang Modal Rp 100.000\n2. Tap Buka Shift", "Shift berstatus Aktif, kasir siap berjualan"],
        ["SHF-M-02", "Karyawan (Kasir)", "Invalid", "Bypass POS Tanpa Buka Shift", "1. Tap menu transaksi saat shift belum dibuka", "Aplikasi memaksa/mengarahkan pengguna untuk buka shift dulu"],
        ["SHF-M-03", "Karyawan (Kasir)", "Valid", "Tutup Shift (Balance)", "1. Tap menu Tutup Shift\n2. Masukkan fisik uang (misal: sesuai hitungan Rp 250k)\n3. Tutup Shift", "Shift berhasil ditutup, status balance selisih Rp 0"],
        ["SHF-M-04", "Karyawan (Kasir)", "Invalid", "Tutup Shift (Selisih Kurang)", "1. Input fisik uang lebih kecil dari hitungan sistem\n2. Tutup Shift", "Shift ditutup, namun status tercatat 'Selisih Minus'"]
    ],
    "Modul: Dashboard / Beranda (Aplikasi Mobile)" => [
        ["DSH-M-01", "Karyawan (Kasir)", "Valid", "Melihat Ringkasan Penjualan Shift", "1. Buka layar utama (Beranda) di aplikasi mobile\n2. Cek card informasi", "Sistem menampilkan ringkasan berupa Total Pendapatan dan Jumlah Transaksi untuk shift yang sedang aktif"],
        ["DSH-M-02", "Karyawan (Kasir)", "Valid", "Navigasi Shortcut Menu", "1. Di Beranda, tap icon shortcut (misal: POS, Kas Keluar, Riwayat)", "Aplikasi mengarahkan ke halaman modul yang sesuai dengan benar"]
    ],
    "Modul: Transaksi POS Penjualan (Aplikasi Mobile)" => [
        ["POS-M-01", "Karyawan (Kasir)", "Valid", "Transaksi Produk Fisik", "1. Tap produk fisik (misal Case HP)\n2. Tap Keranjang\n3. Bayar Pas", "Transaksi berhasil, invoice keluar, STOK BERKURANG di sistem"],
        ["POS-M-02", "Karyawan (Kasir)", "Valid", "Transaksi Produk Digital", "1. Pindah tab Produk Manual/Digital\n2. Pilih nominal Pulsa\n3. Isi No HP\n4. Bayar", "Transaksi berhasil, nomor tujuan tercatat, STOK FISIK TIDAK DIPOTONG"],
        ["POS-M-03", "Karyawan (Kasir)", "Invalid", "Penjualan Stok Kosong", "1. Tap produk fisik yang stoknya 0", "Muncul error 'Stok tidak mencukupi', tidak masuk keranjang"],
        ["POS-M-04", "Karyawan (Kasir)", "Invalid", "Uang Bayar Kurang", "1. Total Rp 50k\n2. Kasir input uang pelanggan Rp 40k\n3. Bayar", "Sistem memblokir pembayaran, validasi uang kurang"],
        ["POS-M-05", "Karyawan (Kasir)", "Valid", "Hitung Kembalian Otomatis", "1. Belanja Rp 25k\n2. Uang pelanggan Rp 50k", "Sistem menampilkan keterangan 'Kembalian Rp 25.000'"],
        ["POS-M-06", "Karyawan (Kasir)", "Valid", "Cetak Struk Bluetooth (Jika ada)", "1. Selesai bayar\n2. Klik Print Struk / otomatis print (jika sudah konek printer)", "Struk transaksi tercetak via printer thermal bluetooth"]
    ],
    "Modul: Kas Keluar (Aplikasi Mobile)" => [
        ["KAS-M-01", "Karyawan (Kasir)", "Valid", "Input Kas Keluar", "1. Buka menu Kas Keluar di HP\n2. Input nominal Rp 50.000, Ket: Konsumsi\n3. Simpan", "Saldo berjalan (laci) otomatis terpotong sejumlah kas keluar tersebut"]
    ],
    "Modul: Riwayat Transaksi (Aplikasi Mobile)" => [
        ["HIS-M-01", "Karyawan (Kasir)", "Valid", "Melihat Riwayat Transaksi Shift Saat Ini", "1. Buka menu Riwayat\n2. Pilih Tab 'Transaksi'", "Menampilkan daftar seluruh struk/invoice yang terjadi di shift berjalan"],
        ["HIS-M-02", "Karyawan (Kasir)", "Valid", "Melihat Detail Transaksi", "1. Tap salah satu item transaksi di daftar riwayat", "Menampilkan detail item yang dibeli, harga, dan waktu transaksi"]
    ],
    "Modul: Riwayat Shift (Aplikasi Mobile)" => [
        ["SHH-M-01", "Karyawan (Kasir)", "Valid", "Melihat Riwayat Shift Sebelumnya", "1. Buka menu Riwayat\n2. Pilih Tab 'Shift'", "Menampilkan daftar history buka/tutup shift yang pernah dilakukan kasir tersebut"],
        ["SHH-M-02", "Karyawan (Kasir)", "Valid", "Detail Selisih Shift", "1. Tap salah satu riwayat shift", "Menampilkan detail modal awal, total pemasukan, pengeluaran, saldo akhir, dan selisihnya"]
    ],
    "Modul: Profil Akun (Aplikasi Mobile)" => [
        ["PRF-M-01", "Karyawan (Kasir)", "Valid", "Melihat Data Profil", "1. Tap icon/menu Profil di navigasi Mobile", "Menampilkan Nama Kasir, Email, dan informasi Cabang tempat bertugas"],
        ["PRF-M-02", "Karyawan (Kasir)", "Valid", "Ubah Password Mobile", "1. Di menu Profil, tap Ubah Password\n2. Input password lama & password baru\n3. Simpan", "Password berhasil diupdate, login selanjutnya wajib pakai password baru"],
        ["PRF-M-03", "Karyawan (Kasir)", "Valid", "Logout Mobile", "1. Di menu Profil, tap tombol Logout", "Sesi mobile berakhir, dikembalikan ke halaman form login HP"]
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
 <Worksheet ss:Name="Test Cases Blackbox Final">
  <Table>
   <Column ss:Width="80"/>
   <Column ss:Width="140"/>
   <Column ss:Width="70"/>
   <Column ss:Width="180"/>
   <Column ss:Width="250"/>
   <Column ss:Width="250"/>
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
echo "Berhasil membuat file Excel (FINAL SUPER LENGKAP): " . $filename . "\n";
?>
