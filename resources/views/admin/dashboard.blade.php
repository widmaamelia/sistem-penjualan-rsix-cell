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
                </div>
                <div class="summary-title">Total Pendapatan Hari Ini</div>
                <h3 class="summary-value">Rp {{ number_format($statistik['pendapatan'], 0, ',', '.') }}</h3>
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
                </div>
                <div class="summary-title">Total Transaksi</div>
                <h3 class="summary-value">{{ $statistik['total_transaksi'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="summary-icon icon-orange">
                        <i class="{{ auth()->user()->role === 'super' ? 'fa-solid fa-store' : 'fa-solid fa-triangle-exclamation' }}"></i>
                    </div>
                </div>
                <div class="summary-title">{{ $statistik['label_cabang'] }}</div>
                <h3 class="summary-value">{{ $statistik['nilai_cabang'] }}</h3>
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
                </div>
                <div class="summary-title">Karyawan Bertugas</div>
                <h3 class="summary-value">{{ $statistik['karyawan'] }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Charts -->
<div class="row g-4 mb-4">
    <!-- Bar Chart -->
    <div class="{{ auth()->user()->role === 'super' ? 'col-md-8' : 'col-12' }}">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header border-0 bg-white pt-4 pb-0">
                <h6 class="mb-0 fw-bold">Penjualan 7 Hari Terakhir</h6>
                <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-secondary" style="font-size: 11px;">Lihat Laporan Lengkap</a>
            </div>
            <div class="card-body">
                <div id="barChart" style="min-height: 250px;"></div>
            </div>
        </div>
    </div>

    <!-- Donut Chart -->
    @if(auth()->user()->role === 'super')
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header border-0 bg-white pt-4 pb-0">
                <h6 class="mb-0 fw-bold">Kontribusi Per Cabang</h6>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                @if($totalPendapatanGlobal > 0)
                    <div id="donutChart" class="d-flex justify-content-center mb-4"></div>
                    
                    <!-- Custom Legend Dynamic -->
                    <div class="px-3">
                        @foreach($donutChartLabels as $index => $label)
                            <div class="legend-item">
                                <div><span class="legend-color" style="background-color: {{ $colorsToPass[$index] }};"></span> {{ $label }}</div>
                                <span class="fw-bold text-dark">{{ number_format(($donutChartData[$index] / $totalPendapatanGlobal) * 100, 1) }}%</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted my-5">
                        <i class="fa-solid fa-chart-pie mb-3" style="font-size: 40px; color: #d1d5db;"></i>
                        <p class="mb-0">Belum ada data pendapatan cabang untuk ditampilkan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Row 3: Table & Price Log -->
<div class="row g-4">
    <div class="{{ auth()->user()->role === 'super' ? 'col-md-8' : 'col-12' }}">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header border-0 bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Transaksi Terbaru</h6>
                <a href="{{ route('laporan.index') }}" class="btn-link-action text-decoration-none" style="font-size: 12px; color: #1a5ca6;">Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="table-container">
                <table class="table mb-0 align-middle">
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
                        @forelse($transaksi_terbaru as $index => $trx)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="tx-id">{{ $trx->no_transaksi }}</td>
                            <td>{{ $trx->cabang->nama_cabang ?? 'Pusat' }}</td>
                            <td>{{ $trx->user->name ?? 'Admin' }}</td>
                            <td>{{ $trx->detailTransaksis->sum('qty') }}</td>
                            <td class="fw-bold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($trx->metode_bayar) }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d M, H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                Belum ada transaksi terbaru hari ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'super')
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header border-0 bg-white py-3">
                <h6 class="mb-0 fw-bold">Log Perubahan Harga Beli</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th style="font-size: 11px; padding: 12px 15px;">Produk</th>
                                <th style="font-size: 11px; padding: 12px 15px;">Harga Beli</th>
                                <th style="font-size: 11px; padding: 12px 15px;">Pengubah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perubahan_harga as $log)
                                <tr>
                                    <td style="padding: 12px 15px; font-size: 12px;">
                                        <span class="fw-bold text-dark">{{ Str::limit($log->produk->nama_produk ?? 'Produk', 20) }}</span>
                                    </td>
                                    <td style="padding: 12px 15px; font-size: 12px;">
                                        <span class="text-muted text-decoration-line-through text-nowrap" style="font-size: 11px;">Rp {{ number_format($log->harga_beli_lama, 0, ',', '.') }}</span>
                                        <br>
                                        <i class="fa-solid fa-arrow-right text-success" style="font-size: 10px;"></i>
                                        <span class="fw-bold text-success text-nowrap">Rp {{ number_format($log->harga_beli_baru, 0, ',', '.') }}</span>
                                    </td>
                                    <td style="padding: 12px 15px; font-size: 11px;">
                                        <div class="fw-semibold text-secondary">{{ $log->user->name ?? '-' }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m, H:i') }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted" style="font-size: 12px;">
                                        <i class="fa-solid fa-clock-rotate-left mb-2 fs-4 text-muted opacity-50"></i>
                                        <div>Belum ada riwayat perubahan harga beli.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Bar Chart (Penjualan 7 Hari Terakhir)
    var barOptions = {
        series: [{
            name: 'Pendapatan',
            data: @json($barChartData)
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
                columnWidth: '60%',
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 2,
            colors: ['#6366f1'] // Garis batas atas seperti di desain
        },
        xaxis: {
            categories: @json($barChartLabels),
            labels: {
                style: { colors: '#9ca3af', fontSize: '11px' }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                },
                style: { colors: '#9ca3af', fontSize: '11px' }
            }
        },
        grid: {
            borderColor: '#f3f4f6',
            strokeDashArray: 4,
            yaxis: {
                lines: { show: true }
            }
        }
    };

    var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
    barChart.render();

    // 2. Donut Chart (Kontribusi Cabang)
    @if(auth()->user()->role === 'super' && $totalPendapatanGlobal > 0)
    var donutOptions = {
        series: @json($donutChartData),
        chart: {
            type: 'donut',
            height: 220,
            fontFamily: 'Inter, sans-serif'
        },
        labels: @json($donutChartLabels),
        colors: @json($colorsToPass),
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
    @endif
});
</script>
@endsection
