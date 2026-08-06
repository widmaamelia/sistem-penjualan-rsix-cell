<?php
// Script untuk men-generate Test Case Blackbox Format Word (.doc) Terpisah per Fitur
$filename = "C:\\Users\\AThariz\\.gemini\\antigravity-ide\\brain\\5fd1bcfd-077a-4e03-bb50-7a8890669438\\Test_Case_Blackbox_Rsix_PerFitur.doc";

$features = [
    "Pengujian Modul: Autentikasi (Web)" => [
        ["TC-AUTH-01", "Super Admin, Admin Cabang", "Login Kredensial Valid Web", "Berada di halaman Login Web", "1. Input email & password yang benar\n2. Klik tombol Login", "Email: super@rsix.com\nPass: 12345", "Sistem mengarahkan pengguna ke halaman Dashboard Web sesuai role", ""],
        ["TC-AUTH-02", "Super Admin, Admin Cabang", "Login Email Salah/Kosong", "Berada di halaman Login Web", "1. Input email salah atau biarkan kosong\n2. Klik tombol Login", "Email: salah@rsix\nPass: 12345", "Sistem menolak akses dan memunculkan peringatan kredensial salah / field wajib diisi", ""],
        ["TC-AUTH-03", "Super Admin, Admin Cabang", "Logout Web", "Pengguna sudah login dan berada di Dashboard", "1. Klik profil di pojok kanan atas\n2. Klik tombol Logout", "-", "Sesi pengguna berakhir, dialihkan kembali ke form Login Web", ""]
    ],
    
    "Pengujian Modul: Dashboard (Web)" => [
        ["TC-DASH-01", "Super Admin", "Melihat Ringkasan Data Semua Cabang", "Super Admin sudah login", "1. Buka menu Dashboard\n2. Cek card Omzet, Transaksi, Total Cabang", "-", "Data yang tampil adalah akumulasi realtime dari seluruh cabang", ""],
        ["TC-DASH-02", "Admin Cabang", "Melihat Ringkasan Data Cabang Sendiri", "Admin Cabang sudah login", "1. Buka menu Dashboard", "-", "Data yang tampil hanya akumulasi transaksi & kasir di cabangnya sendiri", ""]
    ],
    
    "Pengujian Modul: Manajemen Cabang (Web)" => [
        ["TC-CAB-01", "Super Admin", "Tambah Cabang Baru", "Berada di menu Master Cabang", "1. Klik Tambah Cabang\n2. Input nama dan alamat\n3. Klik Simpan", "Nama: Cabang Pusat\nAlamat: Jl. Raya", "Data cabang berhasil tersimpan ke database", ""],
        ["TC-CAB-02", "Super Admin", "Ubah Status Cabang", "Berada di menu Master Cabang", "1. Klik tombol Aktif/Nonaktif pada cabang tertentu", "-", "Status cabang berubah, jika nonaktif maka kasir cabang tsb tidak bisa login", ""],
        ["TC-CAB-03", "Admin Cabang", "Cegah Akses Menu Super Admin", "Admin Cabang sudah login", "1. Ketik URL /cabang secara manual di browser", "URL: /cabang", "Sistem menolak akses (Access Denied / Redirect ke Dashboard)", ""]
    ],
    
    "Pengujian Modul: Manajemen Pengguna (Web)" => [
        ["TC-USR-01", "Super Admin", "Tambah Pengguna Karyawan", "Berada di menu Pengguna", "1. Klik Tambah\n2. Input data, pilih Role: Karyawan, Cabang: A\n3. Simpan", "Email: kasir1@rsix.com\nRole: Karyawan", "Akun karyawan berhasil dibuat dan siap untuk login di Mobile POS", ""],
        ["TC-USR-02", "Super Admin", "Tambah Pengguna Email Duplikat", "Berada di menu Pengguna", "1. Input form dengan email yang sudah ada\n2. Klik Simpan", "Email: kasir1@rsix.com", "Sistem menampilkan validasi error email sudah digunakan", ""],
        ["TC-USR-03", "Super Admin", "Ubah Password Pengguna", "Berada di menu Edit Pengguna", "1. Kosongkan field password jika tidak diubah, atau isi password baru\n2. Simpan", "Password Baru: 54321", "Data berhasil diupdate, pengguna bisa login dengan password baru (jika diubah)", ""]
    ],
    
    "Pengujian Modul: Master Kategori & Shift (Web)" => [
        ["TC-MST-01", "Super Admin", "Tambah Kategori Baru", "Berada di menu Kategori", "1. Klik Tambah\n2. Isi nama kategori\n3. Simpan", "Kategori: Aksesoris HP", "Kategori baru berhasil tersimpan dan tampil di tabel", ""],
        ["TC-MST-02", "Super Admin", "Tambah Master Shift", "Berada di menu Master Shift", "1. Input nama shift dan rentang jam\n2. Simpan", "Nama Shift: Pagi\nJam: 08:00 - 15:00", "Jadwal shift utama tersimpan di database", ""]
    ],

    "Pengujian Modul: Jadwal Shift Karyawan (Web)" => [
        ["TC-JDW-01", "Super Admin, Admin Cabang", "Plotting Jadwal Shift Kasir", "Berada di menu Jadwal Shift", "1. Pilih karyawan, tanggal, dan master shift\n2. Klik Simpan", "Tgl: 25 Okt 2026\nShift: Pagi", "Jadwal kerja karyawan pada tanggal tersebut berhasil diatur", ""],
        ["TC-JDW-02", "Super Admin, Admin Cabang", "Set Izin Karyawan", "Terdapat jadwal karyawan", "1. Klik tombol Set Izin pada jadwal tertentu\n2. Klik Konfirmasi", "-", "Status jadwal berubah menjadi 'Izin'", ""]
    ],
    
    "Pengujian Modul: Manajemen Produk (Web)" => [
        ["TC-PRD-01", "Super Admin, Admin Cabang", "Tambah Produk Fisik", "Berada di form Tambah Produk", "1. Isi form produk\n2. Pilih kategori fisik\n3. Simpan", "Kategori: Fisik\nHarga: 50.000", "Produk tersimpan di database secara normal", ""],
        ["TC-PRD-02", "Super Admin, Admin Cabang", "Tambah Produk Digital/Manual", "Berada di form Tambah Produk", "1. Isi form produk\n2. Pilih kategori yg memuat kata 'Pulsa' atau 'Manual'\n3. Simpan", "Kategori: Pulsa Data", "Tersimpan dengan label produk digital (Icon HP), opsi barcode dinonaktifkan", ""],
        ["TC-PRD-03", "Super Admin, Admin Cabang", "Edit Harga Produk", "Berada di form Edit Produk", "1. Ubah nominal harga jual\n2. Simpan", "Harga Baru: 55.000", "Harga jual produk ter-update dan tersinkronisasi dengan POS Mobile", ""],
        ["TC-PRD-04", "Super Admin, Admin Cabang", "Cetak Barcode Massal", "Ada produk fisik dalam tabel", "1. Centang checkbox pada beberapa produk fisik\n2. Klik Cetak Barcode Massal", "-", "Browser membuka tab baru berisi layout barcode yang siap diprint", ""]
    ],
    
    "Pengujian Modul: Manajemen Stok & Opname (Web)" => [
        ["TC-STK-01", "Super Admin, Admin Cabang", "Input Stok Masuk", "Berada di menu Stok Masuk", "1. Pilih produk & QTY\n2. Simpan", "Produk: Case HP\nQTY: 50", "Stok produk bertambah 50 di cabang terpilih", ""],
        ["TC-STK-02", "Super Admin", "Pindah Stok Antar Cabang", "Berada di menu Pindah Stok", "1. Pilih Cabang Asal, Tujuan, dan QTY\n2. Simpan", "Cab. Asal: A\nCab. Tujuan: B\nQTY: 10", "Stok Cabang A berkurang, dan masuk daftar pengajuan stok untuk Cabang B", ""],
        ["TC-STK-03", "Admin Cabang", "Pengajuan Stok Opname", "Berada di menu Stok Opname", "1. Input jumlah fisik real\n2. Klik Simpan", "Stok Sistem: 20\nStok Fisik: 15", "Opname tersimpan berstatus 'Pending', menunggu approval Super Admin", ""],
        ["TC-STK-04", "Super Admin", "Approve Stok Opname", "Berada di menu Stok Opname", "1. Buka tabel Opname\n2. Klik Approve pada baris ajuan", "-", "Stok di database cabang tersebut otomatis berubah menyesuaikan fisik (15)", ""]
    ],
    
    "Pengujian Modul: Laporan Penjualan (Web)" => [
        ["TC-REP-01", "Super Admin, Admin Cabang", "Filter Laporan Penjualan", "Berada di menu Laporan", "1. Set filter Cabang (Admin Cabang otomatis cabangnya sendiri) dan Tanggal\n2. Klik Terapkan", "Filter: 1-30 Okt", "Menampilkan data rekap penjualan yang sesuai dengan parameter filter", ""],
        ["TC-REP-02", "Super Admin, Admin Cabang", "Export Laporan PDF/Excel", "Laporan sudah terfilter", "1. Klik tombol Unduh Excel / PDF", "-", "File dokumen terunduh berisi data transaksi yang tampil di layar", ""]
    ],
    
    "Pengujian Modul: Autentikasi & Profil (Mobile POS)" => [
        ["TC-MOB-01", "Karyawan (Kasir)", "Login Kasir Mobile", "Berada di halaman Buka Aplikasi", "1. Input email & password\n2. Tap Login", "Email: kasir@rsix.com\nPass: 12345", "Diarahkan ke tampilan beranda POS / Layar Buka Shift", ""],
        ["TC-MOB-02", "Karyawan (Kasir)", "Melihat Profil & Ubah Pass", "Berada di menu Profil Mobile", "1. Cek info profil\n2. Tap Ubah Password\n3. Input pass lama & baru\n4. Simpan", "Pass Baru: kasir321", "Data profil tampil sesuai cabang, password berhasil diperbarui", ""],
        ["TC-MOB-03", "Karyawan (Kasir)", "Logout Mobile", "Aplikasi Mobile terbuka", "1. Ke menu profil\n2. Tap Logout", "-", "Sesi mobile berakhir, dikembalikan ke halaman form login", ""]
    ],
    
    "Pengujian Modul: Buka & Tutup Shift (Mobile POS)" => [
        ["TC-SHF-01", "Karyawan (Kasir)", "Bypass POS Tanpa Buka Shift", "Belum ada shift aktif", "1. Paksa pindah navigasi ke menu POS/Keranjang", "-", "Sistem memblokir dan mengarahkan kembali ke form Buka Shift", ""],
        ["TC-SHF-02", "Karyawan (Kasir)", "Buka Shift dengan Saldo Modal", "Berada di form Buka Shift", "1. Input nominal Uang Laci Awal\n2. Tap Buka Shift", "Uang Laci: 100.000", "Shift berstatus Aktif, fitur transaksi POS bisa digunakan", ""],
        ["TC-SHF-03", "Karyawan (Kasir)", "Tutup Shift (Balance)", "Shift saat ini dalam kondisi Aktif", "1. Tap menu Tutup Shift\n2. Input fisik uang di laci (sama dengan perhitungan sistem)\n3. Tap Tutup Shift", "Uang Fisik: Sesuai Sistem", "Shift tertutup sukses dengan status balance selisih Rp 0", ""],
        ["TC-SHF-04", "Karyawan (Kasir)", "Tutup Shift (Selisih Kurang/Lebih)", "Shift saat ini dalam kondisi Aktif", "1. Input fisik uang di laci lebih kecil/besar dari sistem\n2. Tap Tutup Shift", "Uang Fisik: Berbeda", "Shift tertutup namun tercatat selisihnya dan terekam di sistem pusat (Web)", ""]
    ],
    
    "Pengujian Modul: Transaksi & Kas (Mobile POS)" => [
        ["TC-POS-01", "Karyawan (Kasir)", "Penjualan Produk Fisik", "Shift aktif, produk fisik tersedia", "1. Tap produk fisik\n2. Tap Keranjang\n3. Lanjut Bayar", "Item: Case HP\nQty: 1", "Transaksi berhasil, stok fisik berkurang di backend", ""],
        ["TC-POS-02", "Karyawan (Kasir)", "Penjualan Produk Digital (Pulsa)", "Shift aktif, tab produk digital", "1. Pilih Produk Digital\n2. Input No HP pelanggan\n3. Bayar", "No HP: 0812xxx", "Transaksi berhasil, stok item fisik tidak dikurangi karena ini layanan digital", ""],
        ["TC-POS-03", "Karyawan (Kasir)", "Validasi Stok Kosong", "Stok produk fisik = 0", "1. Tap produk dengan stok = 0\n2. Coba tambahkan ke keranjang", "Stok: 0", "Muncul error toast 'Stok tidak mencukupi', item tidak masuk keranjang", ""],
        ["TC-POS-04", "Karyawan (Kasir)", "Hitung Kembalian Otomatis", "Berada di tahap pembayaran", "1. Total belanja 50.000\n2. Input uang pelanggan 100.000", "Uang Bayar: 100.000", "Sistem menampilkan keterangan 'Kembalian Rp 50.000' sebelum dicetak", ""],
        ["TC-POS-05", "Karyawan (Kasir)", "Validasi Uang Bayar Kurang", "Berada di tahap pembayaran", "1. Total belanja 50.000\n2. Input uang bayar 40.000\n3. Coba bayar", "Uang Bayar: 40.000", "Sistem memblokir pembayaran dan menampilkan peringatan uang tidak cukup", ""],
        ["TC-POS-06", "Karyawan (Kasir)", "Input Kas Keluar Mobile", "Shift aktif", "1. Buka menu Kas Keluar\n2. Input Nominal dan Keterangan\n3. Simpan", "Nominal: 20.000\nKet: Parkir", "Kas keluar tercatat, otomatis memotong saldo hitungan akhir sistem laci", ""]
    ],

    "Pengujian Modul: Riwayat (Mobile POS)" => [
        ["TC-HIS-01", "Karyawan (Kasir)", "Melihat Riwayat Transaksi", "Ada transaksi selesai", "1. Buka menu Riwayat\n2. Pilih Tab Transaksi", "-", "Daftar invoice transaksi penjualan di shift berjalan tampil secara detail", ""],
        ["TC-HIS-02", "Karyawan (Kasir)", "Melihat Riwayat Shift", "Pernah melakukan shift sebelumnya", "1. Buka menu Riwayat\n2. Pilih Tab Shift\n3. Tap riwayat", "-", "Tampil detail modal awal, pendapatan, pengeluaran, saldo akhir, dan selisih", ""]
    ]
];

$html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    body { font-family: "Times New Roman", Times, serif; }
    table { width: 100%; border-collapse: collapse; margin-top: 5px; margin-bottom: 20px; }
    th { background-color: #2F5597; color: white; border: 1px solid black; padding: 5px; text-align: center; font-weight: bold; }
    td { border: 1px solid black; padding: 5px; vertical-align: top; }
    h3 { margin-bottom: 5px; color: #1F497D; font-size: 16px; border-bottom: 2px solid #1F497D; padding-bottom: 3px;}
</style>
</head>
<body>
<h2 style="text-align: center; font-size: 18px;">Skenario Pengujian Blackbox (Test Cases)</h2>';

foreach ($features as $featureName => $rows) {
    $html .= '<h3>' . htmlspecialchars($featureName) . '</h3>';
    $html .= '<table>
    <thead>
        <tr>
            <th width="8%">ID TC</th>
            <th width="12%">Role / Aktor</th>
            <th width="15%">Skenario Uji</th>
            <th width="15%">Precondition</th>
            <th width="20%">Langkah Pengujian</th>
            <th width="10%">Data Uji</th>
            <th width="15%">Hasil Diharapkan</th>
            <th width="5%">Status</th>
        </tr>
    </thead>
    <tbody>';
    
    foreach ($rows as $row) {
        $html .= "<tr>";
        foreach ($row as $col) {
            $html .= "<td>" . nl2br(htmlspecialchars($col)) . "</td>";
        }
        $html .= "</tr>\n";
    }
    
    $html .= '    </tbody>
    </table>';
}

$html .= '</body>
</html>';

file_put_contents($filename, $html);
echo "Berhasil membuat file Word Terpisah per Fitur: " . $filename . "\n";
?>
