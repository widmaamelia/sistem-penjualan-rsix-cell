<?php
// Script untuk men-generate Test Case Blackbox Format Word (.doc)
$filename = "C:\\Users\\AThariz\\.gemini\\antigravity-ide\\brain\\5fd1bcfd-077a-4e03-bb50-7a8890669438\\Test_Case_Blackbox_Rsix_Lengkap.doc";

$data = [
    // Modul: Autentikasi (Web)
    ["TC-01", "Autentikasi (Web)", "Login Kredensial Valid Web", "Pengguna memiliki akun terdaftar dan berada di halaman Login Web", "1. Input email & password yang benar\n2. Klik tombol Login", "Email: super@rsix.com\nPass: 12345", "Sistem mengarahkan pengguna ke halaman Dashboard Web sesuai role", ""],
    ["TC-02", "Autentikasi (Web)", "Login Email Salah/Kosong", "Berada di halaman Login Web", "1. Input email salah atau biarkan kosong\n2. Klik tombol Login", "Email: salah@rsix\nPass: 12345", "Sistem menolak akses dan memunculkan peringatan kredensial salah / field wajib diisi", ""],
    ["TC-03", "Autentikasi (Web)", "Logout Web", "Pengguna sudah login dan berada di Dashboard", "1. Klik profil di pojok kanan atas\n2. Klik tombol Logout", "-", "Sesi pengguna berakhir, dialihkan kembali ke form Login Web", ""],
    
    // Modul: Dashboard (Web)
    ["TC-04", "Dashboard (Web)", "Melihat Ringkasan Data (Super Admin)", "Super Admin sudah login", "1. Buka menu Dashboard\n2. Cek card Omzet, Transaksi, Total Cabang", "-", "Data yang tampil adalah akumulasi realtime dari seluruh cabang", ""],
    ["TC-05", "Dashboard (Web)", "Melihat Ringkasan Data (Admin Cabang)", "Admin Cabang sudah login", "1. Buka menu Dashboard", "-", "Data yang tampil hanya akumulasi transaksi & kasir di cabangnya sendiri", ""],
    
    // Modul: Master Cabang & Pengguna (Web)
    ["TC-06", "Master Cabang (Web)", "Tambah Cabang Baru", "Super Admin berada di menu Master Cabang", "1. Klik Tambah Cabang\n2. Input nama dan alamat\n3. Klik Simpan", "Nama: Cabang Pusat\nAlamat: Jl. Raya", "Data cabang berhasil tersimpan ke database", ""],
    ["TC-07", "Manajemen Pengguna", "Tambah Pengguna Karyawan", "Super Admin berada di menu Pengguna", "1. Klik Tambah\n2. Input data, pilih Role: Karyawan\n3. Simpan", "Email: kasir1@rsix.com\nRole: Karyawan", "Akun karyawan berhasil dibuat dan siap untuk login di Mobile", ""],
    ["TC-08", "Hak Akses (Web)", "Cegah Admin Cabang ke Menu Super", "Admin Cabang sudah login", "1. Buka menu Pengguna atau ketik URL /pengguna secara paksa", "URL: /pengguna", "Sistem menolak akses (Access Denied / Redirect ke Dashboard)", ""],
    
    // Modul: Master Kategori & Shift (Web)
    ["TC-09", "Master Kategori", "Tambah Kategori Baru", "Super Admin berada di menu Kategori", "1. Klik Tambah\n2. Isi nama kategori\n3. Simpan", "Kategori: Aksesoris HP", "Kategori baru berhasil tersimpan dan tampil di tabel", ""],
    ["TC-10", "Master Shift", "Tambah Master Shift", "Super Admin berada di menu Master Shift", "1. Input nama shift dan rentang jam\n2. Simpan", "Nama Shift: Pagi\nJam: 08:00 - 15:00", "Jadwal shift utama tersimpan di database", ""],

    // Modul: Jadwal Shift Karyawan (Web)
    ["TC-11", "Jadwal Shift (Web)", "Plotting Jadwal Shift Kasir", "Admin/Super Admin di menu Jadwal Shift", "1. Pilih karyawan, tanggal, dan master shift\n2. Klik Simpan", "Tgl: 25 Okt 2026\nShift: Pagi", "Jadwal kerja karyawan pada tanggal tersebut berhasil diatur", ""],
    
    // Modul: Manajemen Produk (Web)
    ["TC-12", "Manajemen Produk", "Tambah Produk Fisik", "Admin berada di menu Tambah Produk", "1. Isi form produk\n2. Pilih kategori fisik\n3. Simpan", "Kategori: Fisik (Bukan digital)\nHarga: 50.000", "Produk tersimpan di database secara normal", ""],
    ["TC-13", "Manajemen Produk", "Tambah Produk Digital/Manual", "Admin berada di menu Tambah Produk", "1. Isi form produk\n2. Pilih kategori yg memuat kata 'Pulsa' atau 'Manual'\n3. Simpan", "Kategori: Pulsa All Operator", "Tersimpan dengan label produk digital (Icon HP), opsi barcode dinonaktifkan", ""],
    ["TC-14", "Manajemen Produk", "Cetak Barcode Massal", "Ada produk fisik di dalam database", "1. Centang checkbox pada beberapa produk fisik\n2. Klik Cetak Barcode Massal", "Item 1, Item 2", "Browser membuka tab baru berisi layout barcode yang siap diprint", ""],
    
    // Modul: Manajemen Stok & Opname (Web)
    ["TC-15", "Manajemen Stok", "Input Stok Masuk", "Admin berada di menu Stok Masuk", "1. Pilih produk & QTY\n2. Simpan", "Produk: Case HP\nQTY: 50", "Stok produk bertambah 50 di cabang terpilih", ""],
    ["TC-16", "Manajemen Stok", "Pindah Stok Antar Cabang", "Super Admin di menu Pindah Stok", "1. Pilih Cabang Asal, Tujuan, dan QTY\n2. Simpan", "Cab. Asal: A\nCab. Tujuan: B\nQTY: 10", "Stok Cabang A berkurang, dan masuk daftar pengajuan stok untuk Cabang B", ""],
    ["TC-17", "Stok Opname", "Pengajuan Stok Opname", "Admin Cabang di menu Stok Opname", "1. Input jumlah fisik real\n2. Klik Simpan", "Stok Sistem: 20\nStok Fisik: 15", "Opname tersimpan berstatus 'Pending', menunggu approval Super Admin", ""],
    ["TC-18", "Stok Opname", "Approve Stok Opname", "Super Admin meninjau Opname", "1. Buka tabel Opname\n2. Klik Approve pada baris ajuan", "-", "Stok di database cabang tersebut otomatis berubah menyesuaikan fisik (15)", ""],
    
    // Modul: Laporan Penjualan (Web)
    ["TC-19", "Laporan Penjualan", "Filter Laporan Penjualan", "Admin berada di menu Laporan", "1. Set filter Cabang dan Tanggal\n2. Klik Terapkan", "Filter: 1-30 Okt\nCabang: Semua", "Menampilkan data rekap penjualan yang sesuai dengan parameter filter", ""],
    ["TC-20", "Laporan Penjualan", "Export Laporan Excel", "Tabel laporan menampilkan data", "1. Klik tombol Unduh Excel", "-", "File .xlsx terunduh berisi data transaksi yang sudah difilter", ""],
    
    // Modul: Autentikasi (Aplikasi Mobile)
    ["TC-21", "Autentikasi (Mobile)", "Login Kasir Mobile", "Karyawan memiliki akun dan membuka app", "1. Input email & password\n2. Tap Login", "Email: kasir@rsix.com\nPass: 12345", "Diarahkan ke tampilan beranda POS / Layar Buka Shift", ""],
    
    // Modul: Buka & Tutup Shift (Aplikasi Mobile)
    ["TC-22", "Shift Kasir Mobile", "Buka Shift dengan Saldo Modal", "Kasir baru login dan belum ada shift aktif", "1. Input nominal Uang Laci Awal\n2. Tap Buka Shift", "Uang Laci: 100.000", "Shift berstatus Aktif, fitur transaksi POS bisa digunakan", ""],
    ["TC-23", "Shift Kasir Mobile", "Tutup Shift (Balance)", "Shift saat ini dalam kondisi Aktif", "1. Tap menu Tutup Shift\n2. Input fisik uang di laci (sama dengan sistem)\n3. Tap Tutup Shift", "Uang Fisik: Sesuai", "Shift tertutup sukses dengan status balance selisih Rp 0", ""],
    ["TC-24", "Shift Kasir Mobile", "Tutup Shift (Selisih Kurang)", "Shift saat ini dalam kondisi Aktif", "1. Input fisik uang di laci lebih kecil dari sistem\n2. Tap Tutup Shift", "Uang Fisik: Kurang", "Shift tertutup namun tercatat 'Selisih Minus' dan terekam di sistem pusat", ""],
    
    // Modul: Transaksi POS (Aplikasi Mobile)
    ["TC-25", "Transaksi POS", "Penjualan Produk Fisik", "Shift aktif, produk fisik tersedia", "1. Tap produk fisik\n2. Tap Keranjang\n3. Lanjut Bayar", "Item: Tempered Glass\nQty: 1", "Transaksi berhasil, stok fisik berkurang di backend", ""],
    ["TC-26", "Transaksi POS", "Penjualan Produk Digital (Pulsa)", "Shift aktif, tab produk digital", "1. Pilih Produk Digital\n2. Input No HP pelanggan\n3. Bayar", "No HP: 0812xxx", "Transaksi berhasil, stok item fisik tidak dikurangi karena ini layanan digital", ""],
    ["TC-27", "Transaksi POS", "Validasi Stok Kosong", "Kasir memilih produk fisik yang stoknya 0", "1. Tap produk dengan stok = 0\n2. Coba tambahkan ke keranjang", "Stok: 0", "Muncul error toast 'Stok tidak mencukupi', transaksi tidak dilanjutkan", ""],
    ["TC-28", "Transaksi POS", "Hitung Kembalian & Bayar Kurang", "Berada di tahap pembayaran", "1. Belanja 50k\n2. Input uang pelanggan 40k lalu coba bayar\n3. Input ulang 100k", "Total: 50.000\nBayar: 100.000", "Uang 40k ditolak (Validasi), saat input 100k sistem menampilkan 'Kembalian Rp 50.000' dan berhasil", ""],
    
    // Modul: Kas Keluar, Riwayat, Profil (Aplikasi Mobile)
    ["TC-29", "Kas Keluar Mobile", "Input Kas Keluar", "Shift aktif, ada keperluan operasional laci", "1. Buka menu Kas Keluar\n2. Input Nominal dan Keterangan\n3. Simpan", "Nominal: 50.000\nKet: Makan", "Kas keluar tercatat, otomatis memotong saldo hitungan sistem untuk tutup shift", ""],
    ["TC-30", "Riwayat Transaksi", "Melihat Riwayat Penjualan", "Ada transaksi yang sudah berhasil hari ini", "1. Buka menu Riwayat\n2. Pilih Tab Transaksi", "-", "Daftar invoice transaksi penjualan di shift berjalan tampil secara detail", ""],
    ["TC-31", "Riwayat Shift", "Melihat Riwayat Shift Sebelumnya", "Kasir pernah buka-tutup shift di masa lalu", "1. Buka menu Riwayat\n2. Pilih Tab Shift\n3. Tap riwayat", "-", "Tampil detail modal awal, pengeluaran, saldo akhir, dan status selisih shift", ""],
    ["TC-32", "Profil (Mobile)", "Ubah Password Kasir", "Berada di layar Profil Mobile", "1. Tap Ubah Password\n2. Input password lama & password baru\n3. Simpan", "Pass Baru: kasir321", "Password berhasil diubah, wajib dipakai untuk login selanjutnya", ""]
];

$html = '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    body { font-family: "Times New Roman", Times, serif; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { background-color: #f2f2f2; border: 1px solid black; padding: 5px; text-align: center; font-weight: bold; }
    td { border: 1px solid black; padding: 5px; vertical-align: top; }
    h2 { text-align: center; }
</style>
</head>
<body>
<h2>Skenario Pengujian Blackbox (Test Cases)</h2>
<table>
    <thead>
        <tr>
            <th width="5%">ID TC</th>
            <th width="12%">Modul</th>
            <th width="15%">Skenario Uji</th>
            <th width="15%">Precondition</th>
            <th width="20%">Langkah Pengujian</th>
            <th width="10%">Data Uji</th>
            <th width="15%">Hasil Diharapkan</th>
            <th width="8%">Status</th>
        </tr>
    </thead>
    <tbody>';

foreach ($data as $row) {
    $html .= "<tr>";
    foreach ($row as $col) {
        $html .= "<td>" . nl2br(htmlspecialchars($col)) . "</td>";
    }
    $html .= "</tr>\n";
}

$html .= '    </tbody>
</table>
</body>
</html>';

file_put_contents($filename, $html);
echo "Berhasil membuat file Word: " . $filename . "\n";
?>
