<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - Rsix Cell</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        
        /* Kop Surat (Letterhead) */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }
        .kop-title {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
        }
        .kop-subtitle {
            font-size: 11px;
            margin: 3px 0;
        }
        .kop-line {
            border-top: 2.5px solid #000;
            border-bottom: 0.5px solid #000;
            height: 3px;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        /* Laporan Info */
        .report-title-main {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 20px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 11px;
        }
        .meta-table td {
            padding: 3px 0;
            border: none !important;
        }

        /* Tables styling */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
            text-transform: uppercase;
            border-bottom: 1.5px solid #000;
            padding-bottom: 3px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            border: 1px solid #000;
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            font-size: 10px;
            padding: 6px;
            text-align: left;
            text-transform: uppercase;
        }
        .data-table td {
            border: 1px solid #000;
            padding: 6px;
            color: #000;
        }
        .text-end { text-align: right !important; }
        .text-center { text-align: center !important; }
        .fw-bold { font-weight: bold !important; }

        /* Ringkasan Keuangan Box */
        .summary-container {
            width: 100%;
            margin-bottom: 30px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .summary-box {
            width: 48%;
            border: 1.5px solid #000;
        }
        .summary-box.left {
            float: left;
        }
        .summary-box.right {
            float: right;
        }
        .summary-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-box td {
            padding: 6px 10px;
            border-bottom: 1px solid #000;
        }
        .summary-box tr:last-child td {
            border-bottom: none;
            background-color: #f2f2f2;
        }

        /* Signatures Section */
        .signature-container {
            width: 100%;
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            border: none !important;
            text-align: center;
            width: 50%;
            vertical-align: top;
            font-size: 11px;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body onload="window.print()">
    @php
        $bulanNama = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', 
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', 
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $periodeText = 'Semua Periode';
        if (request('tanggal')) {
            $periodeText = \Carbon\Carbon::parse(request('tanggal'))->format('d F Y');
        } elseif (request('bulan') || request('tahun')) {
            $bulanText = request('bulan') ? ($bulanNama[request('bulan')] ?? request('bulan')) : 'Semua Bulan';
            $tahunText = request('tahun') ?? 'Semua Tahun';
            $periodeText = $bulanText . ' ' . $tahunText;
        }

        $cabangNama = 'Semua Cabang';
        if (auth()->user()->role === 'admin cabang') {
            $cabangNama = auth()->user()->cabang->nama_cabang ?? 'Cabang';
        } elseif (request('id_cabang')) {
            $cabangSelected = \App\Models\Cabang::find(request('id_cabang'));
            $cabangNama = $cabangSelected ? $cabangSelected->nama_cabang : 'Semua Cabang';
        }
    @endphp

    <!-- Kop Surat Resmi -->
    <div class="kop-surat">
        <h1 class="kop-title">RSIX CELL</h1>
        <p class="kop-subtitle">Sistem Informasi Manajemen Ritel Gadget & Pulsa</p>
        <small>Jl. Raya Kampus Udayana, Jimbaran, Badung, Bali | Telp: +62 812-3456-7890</small>
        <div class="kop-line"></div>
    </div>

    <!-- Judul Laporan -->
    <h2 class="report-title-main">LAPORAN KAS MASUK DAN KAS KELUAR</h2>

    <!-- Metadata Laporan -->
    <table class="meta-table">
        <tr>
            <td style="width: 15%;"><strong>Cabang</strong></td>
            <td style="width: 35%;">: {{ $cabangNama }}</td>
            <td style="width: 15%;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 35%;">: {{ date('d M Y H:i') }} WIB</td>
        </tr>
        <tr>
            <td><strong>Periode Laporan</strong></td>
            <td>: {{ $periodeText }}</td>
            <td><strong>Oleh</strong></td>
            <td>: {{ auth()->user()->name }} ({{ auth()->user()->role }})</td>
        </tr>
    </table>

    <!-- 1. Detail Pemasukan (Uang Masuk) -->
    <div class="section-title">Detail Penjualan (Kas Masuk)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;" class="text-center">No</th>
                <th style="width: 30%;">Produk</th>
                <th style="width: 12%;">Tanggal/Waktu</th>
                <th style="width: 14%;">Kasir</th>
                <th style="width: 10%;" class="text-center">Metode</th>
                <th style="width: 10%;" class="text-end">Modal</th>
                <th style="width: 10%;" class="text-end">Laba</th>
                <th style="width: 10%;" class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $t)
                @php
                    $modalTransaksi = 0;
                    foreach ($t->detailTransaksis as $d) {
                        $modalTransaksi += $d->harga_beli_realtime * $d->qty;
                    }
                    $labaTransaksi = $t->total_harga - $modalTransaksi;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        @foreach($t->detailTransaksis as $d)
                            <div style="font-weight: bold;">
                                {{ $d->produk->nama_produk ?? $d->nama_item_manual ?? 'Produk' }}
                                <span style="font-weight: normal; color: #555;">(x{{ $d->qty }})</span>
                            </div>
                            <div style="font-size: 8px; color: #555;">
                                Jual Rp {{ number_format($d->harga_jual_realtime, 0, ',', '.') }}
                                &minus; Beli Rp {{ number_format($d->harga_beli_realtime, 0, ',', '.') }}
                                = Laba Rp {{ number_format(($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty, 0, ',', '.') }}
                            </div>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td class="text-center text-uppercase">{{ $t->metode_bayar }}</td>
                    <td class="text-end">Rp {{ number_format($modalTransaksi, 0, ',', '.') }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($labaTransaksi, 0, ',', '.') }}</td>
                    <td class="text-end">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="color: #666;">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="fw-bold" style="background-color: #f9f9f9;">
                <td colspan="5" class="text-end">TOTAL KESELURUHAN ({{ number_format($totalTransaksi, 0, ',', '.') }} transaksi)</td>
                <td class="text-end">Rp {{ number_format($totalOmzet - $labaKotor, 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
                <td class="text-end">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- 2. Pengeluaran Operasional -->
    <div class="section-title">Pengeluaran Operasional</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 20%;">Tanggal/Waktu</th>
                <th style="width: 25%;">Kasir</th>
                <th style="width: 35%;">Keterangan Pengeluaran</th>
                <th style="width: 15%;" class="text-end">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($operasionals as $index => $kk)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($kk->tanggal)->format('d/m/Y H:i') }}</td>
                    <td>{{ $kk->shift?->user?->name ?? '-' }}</td>
                    <td>{{ $kk->keterangan }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($kk->jumlah_pengeluaran, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #666;">Tidak ada pengeluaran operasional pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="fw-bold" style="background-color: #f9f9f9;">
                <td colspan="4" class="text-end">TOTAL PENGELUARAN OPERASIONAL</td>
                <td class="text-end">Rp {{ number_format($totalOperasional, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- 3. Pembelian Barang Stok -->
    <div class="section-title">Pembelian Barang Stok</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 20%;">Tanggal/Waktu</th>
                <th style="width: 25%;">Kasir</th>
                <th style="width: 35%;">Keterangan Pembelian</th>
                <th style="width: 15%;" class="text-end">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembelianStoks as $index => $kk)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($kk->tanggal)->format('d/m/Y H:i') }}</td>
                    <td>{{ $kk->shift?->user?->name ?? '-' }}</td>
                    <td>{{ $kk->keterangan }}</td>
                    <td class="text-end fw-bold">Rp {{ number_format($kk->jumlah_pengeluaran, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #666;">Tidak ada pembelian stok pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="fw-bold" style="background-color: #f9f9f9;">
                <td colspan="4" class="text-end">TOTAL PEMBELIAN BARANG STOK</td>
                <td class="text-end">Rp {{ number_format($totalPembelianStok, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- 4. Ringkasan Keuangan Formal -->
    <div class="section-title">Ringkasan Keuangan</div>
    <div class="summary-container clearfix">
        <!-- Box Kiri: Laba Kotor -->
        <div class="summary-box left">
            <table>
                <tr>
                    <td colspan="2" class="fw-bold text-center" style="background-color: #e0e0e0; font-size: 11px;">Rincian Laba Kotor</td>
                </tr>
                <tr>
                    <td>Total Uang Masuk (Penjualan)</td>
                    <td class="text-end fw-bold" style="color: green;">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Modal Barang Terjual (HPP)</td>
                    <td class="text-end">- Rp {{ number_format($totalOmzet - $labaKotor, 0, ',', '.') }}</td>
                </tr>
                <tr class="fw-bold">
                    <td>Laba Kotor Penjualan</td>
                    <td class="text-end">Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Box Kanan: Uang Keluar -->
        <div class="summary-box right">
            <table>
                <tr>
                    <td colspan="2" class="fw-bold text-center" style="background-color: #e0e0e0; font-size: 11px;">Rincian Uang Keluar</td>
                </tr>
                <tr>
                    <td>Pengeluaran Operasional</td>
                    <td class="text-end" style="color: red;">Rp {{ number_format($totalOperasional, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Pembelian Barang Stok</td>
                    <td class="text-end" style="color: red;">Rp {{ number_format($totalPembelianStok, 0, ',', '.') }}</td>
                </tr>
                <tr class="fw-bold">
                    <td>Total Uang Keluar</td>
                    <td class="text-end" style="color: red;">Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- 4. Lembar Pengesahan -->
    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td>
                    <p>Dibuat oleh,</p>
                    <div class="signature-space"></div>
                    <p><strong>( ________________________ )</strong></p>
                    <p style="font-size: 10px; color: #555;">Staf Administrasi / Kasir</p>
                </td>
                <td>
                    <p>Mengetahui,</p>
                    <div class="signature-space"></div>
                    <p><strong>( ________________________ )</strong></p>
                    <p style="font-size: 10px; color: #555;">Pemilik / Manajemen Pusat</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>