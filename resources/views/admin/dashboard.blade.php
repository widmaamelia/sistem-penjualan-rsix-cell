@extends('layouts.admin')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* Summary Cards Styling */
    .summary-card {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }
    
    .summary-icon {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .icon-blue { background-color: #eff6ff; color: #3b82f6; }
    .icon-purple { background-color: #f3e8ff; color: #a855f7; }
    .icon-orange { background-color: #ffedd5; color: #f97316; }
    .icon-indigo { background-color: #e0e7ff; color: #6366f1; }

    .summary-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .badge-success { background-color: #dcfce7; color: #166534; }
    .badge-danger { background-color: #fee2e2; color: #991b1b; }
    .badge-neutral { background-color: #f3f4f6; color: #4b5563; }

    .summary-title {
        font-size: 12px;
        color: #6b7280;
        font-weight: 600;
        margin-top: 15px;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 24px;
        font-weight: 700;
        color: #1a5ca6; /* Default RSix blue */
        margin: 0;
    }

    /* Table Styling */
    .table-container {
        overflow-x: auto;
    }

    .table th {
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 600;
        letter-spacing: 0.5px;
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 12px 16px;
    }

    .table td {
        font-size: 13px;
        color: #374151;
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .tx-id {
        color: #1a5ca6;
        font-weight: 600;
    }

    .btn-link-action {
        color: #1a5ca6;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }
    
    .btn-link-action:hover {
        text-decoration: underline;
    }

    /* Legend Donut */
    .legend-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 13px;
        color: #4b5563;
    }
    .legend-color {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<!-- Row 1: Summary Cards -->
<div class="row g-4 mb-4">
    <!-- Card 1 -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="summary-icon icon-blue">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <span class="summary-badge badge-success">+12%</span>
                </div>
                <div class="summary-title">Total Pendapatan Hari Ini</div>
                <h3 class="summary-value">Rp {{ number_format($statistik['pendapatan'] ?? 12450000, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="summary-icon icon-purple">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <span class="summary-badge badge-success">+8%</span>
                </div>
                <div class="summary-title">Total Transaksi</div>
                <h3 class="summary-value">{{ $statistik['total_transaksi'] ?? 247 }}</h3>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="summary-icon icon-orange">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <span class="summary-badge badge-neutral">Tetap</span>
                </div>
                <div class="summary-title">Cabang Aktif</div>
                <h3 class="summary-value">{{ $statistik['cabang_aktif'] ?? '5/6' }}</h3>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="summary-icon icon-indigo">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <span class="summary-badge badge-danger">-2</span>
                </div>
                <div class="summary-title">Karyawan Bertugas</div>
                <h3 class="summary-value">{{ $statistik['karyawan'] ?? 12 }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Charts -->
<div class="row g-4 mb-4">
    <!-- Bar Chart -->
    <div class="col-md-8">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header border-0 bg-white pt-4 pb-0">
                <h6 class="mb-0 fw-bold">Penjualan 30 Hari Terakhir</h6>
                <button class="btn btn-sm btn-outline-secondary" style="font-size: 11px;">Unduh Laporan</button>
            </div>
            <div class="card-body">
                <div id="barChart" style="min-height: 250px;"></div>
            </div>
        </div>
    </div>

    <!-- Donut Chart -->
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header border-0 bg-white pt-4 pb-0">
                <h6 class="mb-0 fw-bold">Kontribusi Per Cabang</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div id="donutChart" class="d-flex justify-content-center mb-4"></div>
                
                <!-- Custom Legend -->
                <div class="px-3">
                    <div class="legend-item">
                        <div><span class="legend-color" style="background-color: #1a5ca6;"></span> Alahan Panjang</div>
                        <span class="fw-bold text-dark">45%</span>
                    </div>
                    <div class="legend-item">
                        <div><span class="legend-color" style="background-color: #6366f1;"></span> Talang Babungo</div>
                        <span class="fw-bold text-dark">25%</span>
                    </div>
                    <div class="legend-item">
                        <div><span class="legend-color" style="background-color: #92400e;"></span> Cabang Diponegoro</div>
                        <span class="fw-bold text-dark">30%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="mb-0 fw-bold">Transaksi Terbaru</h6>
                <a href="#" class="btn-link-action">Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="table-container">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Cabang</th>
                            <th>Kasir</th>
                            <th>Jumlah Item</th>
                            <th>Total</th>
                            <th>Metode Bayar</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Menggunakan data dari controller jika ada, atau fallback ke dummy untuk tampilan awal -->
                        @forelse($transaksi_terbaru ?? [] as $index => $trx)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="tx-id">{{ $trx->no_transaksi }}</td>
                            <td>{{ $trx->cabang->nama_cabang ?? 'Pusat' }}</td>
                            <td>{{ $trx->user->name ?? 'Admin' }}<br><small class="text-muted" style="font-size:11px;">Shift {{ $trx->shift->id_shift ?? '-' }}</small></td>
                            <td>{{ $trx->detailTransaksis->sum('qty') }}</td>
                            <td class="fw-bold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($trx->metode_bayar) }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('H:i') }}</td>
                        </tr>
                        @empty
                        <!-- Dummy Data jika DB kosong atau Controller belum kirim data -->
                        <tr>
                            <td>1</td>
                            <td class="tx-id">#TX-9921</td>
                            <td>Alahan Panjang</td>
                            <td>Budi Santoso</td>
                            <td>3</td>
                            <td class="fw-bold">Rp 450.000</td>
                            <td>QRIS</td>
                            <td>14:20</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="tx-id">#TX-9920</td>
                            <td>Talang Babungo</td>
                            <td>Sari Putri</td>
                            <td>1</td>
                            <td class="fw-bold">Rp 1.200.000</td>
                            <td>Tunai</td>
                            <td>14:15</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="tx-id">#TX-9919</td>
                            <td>Talang Babungo</td>
                            <td>Sari Putri</td>
                            <td>2</td>
                            <td class="fw-bold">Rp 85.000</td>
                            <td>Tunai</td>
                            <td>14:02</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td class="tx-id">#TX-9918</td>
                            <td>Alahan Panjang</td>
                            <td>Ani Wijaya</td>
                            <td>5</td>
                            <td class="fw-bold">Rp 2.150.000</td>
                            <td>Debit BCA</td>
                            <td>13:55</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td class="tx-id">#TX-9917</td>
                            <td>Cabang Diponegoro</td>
                            <td>Rian Hidayat</td>
                            <td>1</td>
                            <td class="fw-bold">Rp 15.000</td>
                            <td>Tunai</td>
                            <td>13:48</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Footer -->
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
                <div>Menampilkan <strong>1-5</strong> dari <strong>124</strong> transaksi</div>
                
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link border-0 text-muted" href="#"><i class="fa-solid fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link border-0" href="#" style="background-color: #1a5ca6;">1</a></li>
                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">2</a></li>
                        <li class="page-item"><a class="page-link border-0 text-dark" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link border-0 text-dark" href="#"><i class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Bar Chart (Penjualan 30 Hari Terakhir)
    var barOptions = {
        series: [{
            name: 'Penjualan',
            data: [120, 90, 150, 110, 140] // Data dummy sesuai grafik desain
        }],
        chart: {
            type: 'bar',
            height: 250,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#a5b4fc'], // Light blue-purple
        plotOptions: {
            bar: {
                borderRadius: 2,
                columnWidth: '85%',
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 2,
            colors: ['#6366f1'] // Garis batas atas seperti di desain
        },
        xaxis: {
            categories: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
            labels: {
                style: { colors: '#9ca3af', fontSize: '11px' }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: { show: false },
        grid: { show: false }
    };

    var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
    barChart.render();

    // 2. Donut Chart (Kontribusi Cabang)
    var donutOptions = {
        series: [45, 25, 30],
        chart: {
            type: 'donut',
            height: 220,
            fontFamily: 'Inter, sans-serif'
        },
        labels: ['Alahan Panjang', 'Talang Babungo', 'Cabang Diponegoro'],
        colors: ['#1a5ca6', '#6366f1', '#92400e'],
        plotOptions: {
            pie: {
                donut: {
                    size: '75%',
                    labels: {
                        show: true,
                        name: { show: false },
                        value: {
                            show: true,
                            fontSize: '24px',
                            fontWeight: 700,
                            color: '#1a5ca6',
                            formatter: function (val) {
                                return "100%" // Label tengah
                            }
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        legend: { show: false }, // Legend custom dibuat di HTML
        stroke: { width: 0 }
    };

    var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
    donutChart.render();
});
</script>
@endsection
