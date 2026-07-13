<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - Rsix Cell</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            font-size: 10px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        
        /* Kop Surat (Letterhead) */
        .kop-surat {
            text-align: center;
            margin-bottom: 15px;
        }
        .kop-title {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
        }
        .kop-subtitle {
            font-size: 10px;
            margin: 2px 0;
        }
        .kop-line {
            border-top: 2px solid #000;
            border-bottom: 0.5px solid #000;
            height: 3px;
            margin-top: 4px;
            margin-bottom: 15px;
        }

        /* Laporan Info */
        .report-title-main {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 15px;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10px;
        }
        .meta-table td {
            padding: 2px 0;
            border: none !important;
        }

        /* Tables styling */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            margin-top: 12px;
            margin-bottom: 6px;
            text-transform: uppercase;
            border-bottom: 1.5px solid #000;
            padding-bottom: 2px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th {
            border: 1px solid #000;
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            font-size: 9px;
            padding: 5px;
            text-align: left;
            text-transform: uppercase;
        }
        .data-table td {
            border: 1px solid #000;
            padding: 5px;
            color: #000;
        }
        .text-end { text-align: right !important; }
        .text-center { text-align: center !important; }
        .fw-bold { font-weight: bold !important; }

        /* Ringkasan Keuangan Box */
        .summary-box {
            width: 45%;
            border: 1.5px solid #000;
            margin-bottom: 20px;
        }
        .summary-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-box td {
            padding: 5px 8px;
            border-bottom: 1px solid #000;
        }
        .summary-box tr:last-child td {
            border-bottom: none;
            background-color: #f2f2f2;
        }

        /* Signatures Section */
        .signature-container {
            width: 100%;
            margin-top: 30px;
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
            font-size: 10px;
        }
        .signature-space {
            height: 45px;
        }
    </style>
</head>
<body>
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
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 30%;">Produk</th>
                <th style="width: 15%;">Tanggal/Waktu</th>
                <th style="width: 20%;">Kasir</th>
                <th style="width: 15%;" class="text-center">Metode</th>
                <th style="width: 15%;" class="text-end">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $totalKeseluruhan = 0; @endphp
            @forelse($transaksis as $index => $t)
                @php $totalKeseluruhan += $t->total_harga; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        @foreach($t->detailTransaksis as $d)
                            <div style="font-weight: bold;">
                                {{ $d->produk->nama_produk ?? $d->nama_item_manual ?? 'Produk' }}
                                <span style="font-weight: normal; color: #555;">(x{{ $d->qty }})</span>
                            </div>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y H:i') }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td class="text-center text-uppercase">{{ $t->metode_bayar }}</td>
                    <td class="text-end">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="color: #666;">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="fw-bold" style="background-color: #f9f9f9;">
                <td colspan="5" class="text-end">TOTAL OMZET PENJUALAN (KAS MASUK)</td>
                <td class="text-end">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- 2. Detail Pengeluaran (Uang Keluar) -->
    <div class="section-title">Rincian Pengeluaran Kas (Kas Keluar)</div>
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
            @forelse($kasKeluars as $index => $kk)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($kk->tanggal)->format('d/m/Y H:i') }}</td>
                    <td>{{ $kk->shift?->user?->name ?? '-' }}</td>
                    <td>{{ $kk->keterangan }}</td>
                    <td class="text-end text-danger fw-bold">Rp {{ number_format($kk->jumlah_pengeluaran, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="color: #666;">Tidak ada pengeluaran kas pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="fw-bold" style="background-color: #f9f9f9;">
                <td colspan="4" class="text-end">TOTAL KAS KELUAR</td>
                <td class="text-end text-danger">Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- 3. Ringkasan Keuangan Formal -->
    <div class="section-title">Ikhtisar Keuangan</div>
    <div class="summary-box">
        <table>
            <tr>
                <td>Total Uang Masuk (Pemasukan Penjualan)</td>
                <td class="text-end fw-bold" style="color: green;">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Uang Keluar (Restok & Operasional)</td>
                <td class="text-end fw-bold" style="color: red;">- Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</td>
            </tr>
            <tr class="fw-bold">
                <td>Margin Laba Kotor Penjualan</td>
                <td class="text-end">Rp {{ number_format($labaKotor, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <!-- 4. Lembar Pengesahan -->
    <div class="signature-container">
        <table class="signature-table">
            <tr>
                <td>
                    <p>Dibuat oleh,</p>
                    <div class="signature-space"></div>
                    <p><strong>( ________________________ )</strong></p>
                    <p style="font-size: 9px; color: #555;">Staf Administrasi / Kasir</p>
                </td>
                <td>
                    <p>Mengetahui,</p>
                    <div class="signature-space"></div>
                    <p><strong>( ________________________ )</strong></p>
                    <p style="font-size: 9px; color: #555;">Pemilik / Manajemen Pusat</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
