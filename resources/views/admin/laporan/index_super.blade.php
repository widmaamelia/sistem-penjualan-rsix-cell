@extends('layouts.admin')

@section('title', 'Rekap Laporan Seluruh Cabang')

@section('content')

<!-- Ringkasan Dashboard Global -->
<div class="row g-2 mb-3">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-secondary text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Transaksi Global</h6>
                    <h4 class="m-0 fw-bold">{{ number_format($globalTransaksi, 0, ',', '.') }}</h4>
                </div>
                <div class="fs-3 text-white-50">
                    <i class="fa-solid fa-globe"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-success text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Uang Masuk Global</h6>
                    <h4 class="m-0 fw-bold">Rp {{ number_format($globalUangMasuk, 0, ',', '.') }}</h4>
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
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Uang Keluar Global</h6>
                    <h4 class="m-0 fw-bold">Rp {{ number_format($globalUangKeluar, 0, ',', '.') }}</h4>
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
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Laba Kotor Global</h6>
                    <h4 class="m-0 fw-bold">Rp {{ number_format($globalLaba, 0, ',', '.') }}</h4>
                </div>
                <div class="fs-3 text-white-50">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Bulan</label>
                <select name="bulan" class="form-select">
                    <option value="">-- Semua Bulan --</option>
                    @for($i=1; $i<=12; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ request('bulan') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Tahun</label>
                <select name="tahun" class="form-select">
                    <option value="">-- Semua Tahun --</option>
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
                <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6;">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-2 border-bottom">
        <h6 class="m-0 fw-bold">Rekapitulasi Per Cabang</h6>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle table-hover text-nowrap">
            <thead class="bg-light">
                <tr>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">NAMA CABANG</th>
                    <th class="py-2 px-3 text-muted text-center" style="font-size: 11px;">TRANSAKSI</th>
                    <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">UANG MASUK</th>
                    <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">UANG KELUAR</th>
                    <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">LABA KOTOR</th>
                    <th class="py-2 px-3 text-muted text-center" style="font-size: 11px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cabangs as $cabang)
                    <tr>
                        <td class="px-3 py-2">
                            <span class="fw-bold text-primary d-block" style="font-size: 13px;">{{ $cabang->nama_cabang }}</span>
                            <small class="text-muted" style="font-size: 11px;">{{ Str::limit($cabang->alamat, 30) }}</small>
                        </td>
                        <td class="px-3 py-2 text-center fw-bold text-dark" style="font-size: 12px;">{{ $cabang->total_transaksi }}</td>
                        <td class="px-3 py-2 text-end fw-bold text-success" style="font-size: 12px;">Rp {{ number_format($cabang->total_uang_masuk, 0, ',', '.') }}</td>
                        <td class="px-3 py-2 text-end fw-bold text-danger" style="font-size: 12px;">Rp {{ number_format($cabang->total_uang_keluar, 0, ',', '.') }}</td>
                        <td class="px-3 py-2 text-end fw-bold text-info" style="font-size: 12px;">Rp {{ number_format($cabang->total_laba, 0, ',', '.') }}</td>
                        <td class="px-3 py-2 text-center">
                            @php
                                $detailParams = request()->all();
                                $detailParams['id_cabang'] = $cabang->id_cabang;
                            @endphp
                            <a href="{{ route('laporan.index', $detailParams) }}" class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2" style="font-size: 11px;">
                                <i class="fa-solid fa-list-check"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
