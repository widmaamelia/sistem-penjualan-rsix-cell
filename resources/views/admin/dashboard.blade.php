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
<div class="row g-3 mb-4">
    <!-- Card 1 -->
    <div class="col-lg col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Pendapatan Hari Ini</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px; color: #1a5ca6;">Rp {{ number_format($statistik['pendapatan'], 0, ',', '.') }}</h5>
                </div>
                <div class="summary-icon icon-blue fs-4" style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px;">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="col-lg col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Transaksi Hari Ini</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px; color: #1a5ca6;">{{ $statistik['total_transaksi'] }}</h5>
                </div>
                <div class="summary-icon icon-purple fs-4" style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px;">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-lg col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px;">{{ $statistik['label_cabang'] }}</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px; color: #1a5ca6;">{{ $statistik['nilai_cabang'] }}</h5>
                </div>
                <div class="summary-icon icon-orange fs-4" style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px;">
                    <i class="{{ auth()->user()->role === 'super' ? 'fa-solid fa-store' : 'fa-solid fa-triangle-exclamation' }}"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-lg col-md-6">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px;">Karyawan Bertugas</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px; color: #1a5ca6;">{{ $statistik['karyawan'] }}</h5>
                </div>
                <div class="summary-icon icon-indigo fs-4" style="width: 45px; height: 45px; flex-shrink: 0; border-radius: 12px;">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Charts -->
<div class="row g-4 mb-4">
    <!-- Bar Chart -->
    <div class="{{ auth()->user()->role === 'super' ? 'col-md-8' : 'col-12' }}">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header border-0 bg-white pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" style="font-size: 15px;">Penjualan 7 Hari Terakhir</h6>
                <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary" style="border-radius: 6px; font-weight: 500; padding: 4px 10px; font-size: 11.5px;">Lihat Laporan Lengkap</a>
            </div>
            <div class="card-body pb-0 d-flex flex-column justify-content-center">
                <div id="barChart"></div>
            </div>
        </div>
    </div>

    <!-- Donut Chart -->
    @if(auth()->user()->role === 'super')
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header border-0 bg-white pt-4 pb-0">
                <h6 class="mb-0 fw-bold" style="font-size: 15px;">Kontribusi Per Cabang</h6>
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
                <h6 class="mb-0 fw-bold" style="font-size: 15px;">Transaksi Terbaru</h6>
                <a href="{{ route('laporan.index') }}" class="btn-link-action text-decoration-none" style="font-size: 12px; color: #1a5ca6;">Lihat Semua <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
            <div class="table-container">
                <table class="table mb-0 align-middle table-hover">
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
                            <td>
                                @if(strtolower($trx->metode_bayar) === 'tunai')
                                    <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 10px; padding: 4px 8px;">{{ ucfirst($trx->metode_bayar) }}</span>
                                @else
                                    <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 10px; padding: 4px 8px;">{{ ucfirst($trx->metode_bayar) }}</span>
                                @endif
                            </td>
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
            <div class="card-header border-0 bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold" style="font-size: 15px;">Log Perubahan Harga Beli</h6>
                <a href="{{ route('produk.index') }}" class="btn-link-action text-decoration-none" style="font-size: 11px; color: #1a5ca6;">Semua Produk <i class="fa-solid fa-arrow-right ms-1"></i></a>
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
            height: 240,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        colors: ['#1a5ca6'], // Vibrant Rsix Primary Blue
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '45%',
                distributed: false,
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.3,
                gradientToColors: ['#3b82f6'], // Smooth blue gradient
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 0.85,
                stops: [0, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 0,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($barChartLabels),
            labels: {
                style: { colors: '#6b7280', fontSize: '12px', fontWeight: 600 }
            },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        tooltip: {
            theme: 'light',
            y: {
                formatter: function (val) {
                    return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                },
                style: { colors: '#6b7280', fontSize: '11px', fontWeight: 500 }
            }
        },
        grid: {
            borderColor: '#f3f4f6',
            strokeDashArray: 4,
            padding: { bottom: 0, left: 10, right: 10 },
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
            height: 190,
            fontFamily: 'Inter, sans-serif'
        },
        labels: @json($donutChartLabels),
        colors: @json($colorsToPass),
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
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
