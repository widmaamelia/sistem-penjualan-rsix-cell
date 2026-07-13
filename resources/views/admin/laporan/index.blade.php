@extends('layouts.admin')

@section('title', isset($cabangSpesifik) ? 'Detail Laporan: ' . $cabangSpesifik->nama_cabang : 'Laporan Penjualan')

@section('content')

@if(isset($cabangSpesifik))
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h4 class="m-0 fw-bold">Cabang: {{ $cabangSpesifik->nama_cabang }}</h4>
        <small class="text-muted">{{ $cabangSpesifik->alamat }}</small>
    </div>
</div>
@endif

<!-- Ringkasan Dashboard -->
<div class="row g-2 mb-3">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-secondary text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Transaksi</h6>
                    <h4 class="m-0 fw-bold">{{ number_format($totalTransaksi, 0, ',', '.') }}</h4>
                </div>
                <div class="fs-3 text-white-50">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-success text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Uang Masuk</h6>
                    <h4 class="m-0 fw-bold">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</h4>
                </div>
                <div class="fs-3 text-white-50">
                    <i class="fa-solid fa-circle-arrow-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-danger text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Uang Keluar</h6>
                    <h4 class="m-0 fw-bold">Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</h4>
                </div>
                <div class="fs-3 text-white-50">
                    <i class="fa-solid fa-circle-arrow-up"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-info text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Laba Kotor</h6>
                    <h4 class="m-0 fw-bold">Rp {{ number_format($labaKotor, 0, ',', '.') }}</h4>
                </div>
                <div class="fs-1 text-white-50">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
            @if(isset($cabangSpesifik))
                <input type="hidden" name="id_cabang" value="{{ $cabangSpesifik->id_cabang }}">
            @endif
            
            <div class="col-md-3">
                <label class="form-label text-muted" style="font-size: 12px;">Bulan</label>
                <select name="bulan" class="form-select">
                    <option value="">-- Bulan --</option>
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted" style="font-size: 12px;">Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">-- Tahun --</option>
                    @for($i=date('Y'); $i>=date('Y')-5; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 12px;">Atau Tanggal Spesifik</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>
            <div class="col-md-2 d-grid gap-2">
                <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6;">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Riwayat Transaksi (Uang Masuk)</h5>
        <div class="btn-group">
            <a href="{{ route('laporan.print', request()->all()) }}" target="_blank" class="btn btn-outline-secondary">
                <i class="fa-solid fa-print"></i> Print
            </a>
            <a href="{{ route('laporan.export.pdf', request()->all()) }}" class="btn btn-outline-danger">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('laporan.export.excel', request()->all()) }}" class="btn btn-outline-success">
                <i class="fa-solid fa-file-excel"></i> Excel
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle table-hover">
            <thead class="bg-light">
                <tr>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">PRODUK</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">TANGGAL</th>
                    @if(auth()->user()->role === 'super')
                        <th class="py-2 px-3 text-muted" style="font-size: 11px;">CABANG</th>
                    @endif
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">KASIR</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">METODE</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">TOTAL</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                    <tr>
                        <td class="px-3 py-2">
                            @foreach($t->detailTransaksis as $d)
                                <div style="font-size: 12px; font-weight: 600;" class="text-dark">
                                    {{ $d->produk->nama_produk ?? $d->nama_item_manual ?? 'Produk' }}
                                    <span class="text-muted">(x{{ $d->qty }})</span>
                                </div>
                            @endforeach
                        </td>
                        <td class="px-3 py-2" style="font-size: 12px;">{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d M Y H:i') }}</td>
                        @if(auth()->user()->role === 'super')
                            <td class="px-3 py-2" style="font-size: 12px;">{{ $t->cabang->nama_cabang ?? '-' }}</td>
                        @endif
                        <td class="px-3 py-2" style="font-size: 12px;">{{ $t->user->name ?? '-' }}</td>
                        <td class="px-3 py-2">
                            @if($t->metode_bayar === 'tunai')
                                <span class="badge bg-success bg-opacity-10 text-success" style="font-size: 10px; padding: 2px 6px;">{{ $t->metode_bayar }}</span>
                            @else
                                <span class="badge bg-primary bg-opacity-10 text-primary" style="font-size: 10px; padding: 2px 6px;">{{ $t->metode_bayar }}</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 fw-bold text-dark" style="font-size: 12px;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="px-3 py-2">
                            <a href="{{ route('laporan.show', $t->id_transaksi) }}" class="btn btn-sm btn-outline-info py-0 px-2" style="font-size: 11px;">
                                <i class="fa-regular fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'super' ? '7' : '6' }}" class="text-center py-4 text-muted" style="font-size: 12px;">Belum ada data transaksi yang cocok dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transaksis->hasPages())
        <div class="card-footer bg-white border-top py-2 px-3">
            {{ $transaksis->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- Rincian Uang Keluar (Kas Keluar) -->
<div class="card shadow-sm border-0 rounded-3 mt-3">
    <div class="card-header bg-white py-2">
        <h6 class="m-0 fw-bold"><i class="fa-solid fa-circle-chevron-up text-danger me-2"></i> Rincian Uang Keluar (Kas Keluar)</h6>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle table-hover text-nowrap">
            <thead class="bg-light">
                <tr>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">TANGGAL</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">KASIR</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">KETERANGAN</th>
                    <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">NOMINAL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kasKeluars as $kk)
                    <tr>
                        <td class="px-3 py-2" style="font-size: 12px;">{{ \Carbon\Carbon::parse($kk->tanggal)->format('d M Y H:i') }}</td>
                        <td class="px-3 py-2" style="font-size: 12px;">{{ $kk->shift?->user?->name ?? '-' }}</td>
                        <td class="px-3 py-2 text-wrap" style="max-width: 400px; font-size: 12px;">{{ $kk->keterangan }}</td>
                        <td class="px-3 py-2 text-end fw-bold text-danger" style="font-size: 12px;">Rp {{ number_format($kk->jumlah_pengeluaran, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-3 text-muted" style="font-size: 12px;">Belum ada pengeluaran kas pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
