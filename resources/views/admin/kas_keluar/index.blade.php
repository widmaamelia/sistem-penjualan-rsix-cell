@extends('layouts.admin')

@section('title', 'Kas Keluar')

@section('styles')
<style>
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 15px;
    }

    .search-input {
        width: 350px;
        position: relative;
    }

    .search-input i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .search-input input {
        padding-left: 40px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .btn-primary-custom {
        background-color: #1a5ca6;
        border-color: #1a5ca6;
        color: white;
        font-weight: 500;
        border-radius: 8px;
        padding: 8px 16px;
    }

    .btn-primary-custom:hover {
        background-color: #154a85;
        color: white;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .table th {
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 700;
        letter-spacing: 0.5px;
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 16px;
        vertical-align: middle;
    }

    .table td {
        font-size: 13px;
        color: #374151;
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .action-icons {
        display: flex;
        gap: 12px;
    }
    
    .action-icons button {
        background: none;
        border: none;
        padding: 0;
        color: #6b7280;
        font-size: 14px;
        transition: color 0.2s;
        cursor: pointer;
    }
    
    .action-icons button.text-primary:hover {
        color: #1a5ca6 !important;
    }
    
    .action-icons button.text-danger:hover {
        color: #dc2626 !important;
    }

    /* Ringkasan di bawah tabel */
    .summary-panel {
        border-top: 1px solid #e5e7eb;
        background-color: #f9fafb;
        padding: 18px 20px 0 20px;
    }
    .summary-panel .summary-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
    }
    .summary-panel .summary-total {
        font-size: 26px;
        font-weight: 700;
        color: #dc2626;
        line-height: 1.2;
        margin-top: 2px;
    }
    .summary-panel .summary-meta {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
    .summary-panel .summary-breakdown {
        display: flex;
        flex-wrap: wrap;
        gap: 28px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px dashed #e5e7eb;
    }
    .summary-panel .summary-item {
        min-width: 170px;
    }
    .summary-panel .summary-item-head {
        font-size: 11px;
        font-weight: 600;
        color: #4b5563;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .summary-panel .summary-item-head .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .summary-panel .summary-item-value {
        font-size: 16px;
        font-weight: 700;
        margin-top: 3px;
    }
    .summary-panel .summary-item-note {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 1px;
    }
    .summary-panel .summary-bar {
        display: flex;
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        background-color: #e5e7eb;
        margin-top: 16px;
    }

    @media (min-width: 992px) {
        .summary-panel {
            display: grid;
            grid-template-columns: minmax(240px, 1fr) auto;
            grid-template-areas: "main breakdown" "bar bar";
            column-gap: 32px;
            align-items: center;
        }
        .summary-panel .summary-main { grid-area: main; }
        .summary-panel .summary-breakdown {
            grid-area: breakdown;
            margin-top: 0;
            padding-top: 0;
            border-top: 0;
        }
        .summary-panel .summary-bar { grid-area: bar; }
    }
</style>
@endsection

@section('content')

<!-- Notifikasi -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 14px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 14px;">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" style="font-size: 14px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Header -->
<div class="d-flex justify-content-end align-items-center mb-3">
    @if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super')
    <a href="{{ route('kas_keluar.create') }}" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">
        <i class="fa-solid fa-plus me-1"></i> Catat Kas Keluar
    </a>
    @endif
</div>

<!-- Action Bar -->
<div class="action-bar mb-3">
    <form action="{{ route('kas_keluar.index') }}" method="GET" class="d-flex gap-2 m-0 flex-wrap align-items-center w-100">
        <div class="search-input" style="width: 220px; position: relative;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 13px;"></i>
            <input type="text" name="search" class="form-control" placeholder="Cari keterangan..." value="{{ request('search') }}" style="border-radius: 6px; padding: 6px 12px 6px 32px; font-size: 13.5px;">
        </div>
        @if(auth()->user()->role === 'super')
            <select name="id_cabang" class="form-select" style="width: 170px; border-radius: 6px; font-size: 13.5px; padding: 6px 32px 6px 12px;">
                <option value="">-- Semua Cabang --</option>
                @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->id_cabang }}" {{ request('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                @endforeach
            </select>
        @endif

        <select name="bulan" class="form-select" style="width: 160px; border-radius: 6px; font-size: 13.5px; padding: 6px 32px 6px 12px;">
            <option value="">-- Semua Bulan --</option>
            @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                      '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                      '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $angka => $nama)
                <option value="{{ $angka }}" {{ request('bulan') === $angka ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
        </select>

        <select name="tahun" class="form-select" style="width: 150px; border-radius: 6px; font-size: 13.5px; padding: 6px 32px 6px 12px;">
            <option value="">-- Semua Tahun --</option>
            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>

        <input type="date" name="tanggal" class="form-control" style="width: 145px; border-radius: 6px; font-size: 13.5px; padding: 6px 12px;"
               value="{{ request('tanggal') }}" title="Tanggal spesifik">

        <button type="submit" class="btn btn-outline-secondary" style="border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Filter</button>
        @if(request()->hasAny(['search', 'id_cabang', 'bulan', 'tahun', 'tanggal']))
            <a href="{{ route('kas_keluar.index') }}" class="btn btn-light border" style="border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Reset</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="table-container shadow-sm">
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="width: 60px; padding-left: 20px;">No</th>
                <th>Tanggal & Waktu</th>
                <th>Cabang</th>
                <th>Jumlah Pengeluaran</th>
                <th>Tipe Pengeluaran</th>
                @if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super')
                <th style="width: 80px;">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($kasKeluars as $index => $item)
                @php
                    $isAutoRestock = str_contains(strtolower($item->keterangan), 'restock');
                    $isAutoOpname = str_contains(strtolower($item->keterangan), 'opname');
                    $isManual = !$isAutoRestock && !$isAutoOpname;
                    $cabangName = $item->cabang->nama_cabang ?? ($item->shift->cabang->nama_cabang ?? 'Cabang Dihapus');
                @endphp
                <tr>
                    <td class="text-muted" style="padding-left: 20px;">{{ $kasKeluars->firstItem() + $index }}</td>
                    <td class="fw-medium text-dark">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y, H:i') }} WIB
                    </td>
                    <td>
                        <span class="text-primary fw-medium">{{ $cabangName }}</span>
                    </td>
                    <td class="fw-bold text-danger">
                        Rp {{ number_format($item->jumlah_pengeluaran, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($isAutoRestock)
                            <span class="badge bg-info bg-opacity-10 text-info px-2 py-1" style="font-size: 11px;">Sistem (Restock)</span>
                        @elseif($isAutoOpname)
                            <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1" style="font-size: 11px;">Sistem (Opname)</span>
                        @else
                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1" style="font-size: 11px;">Manual (Operasional)</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super')
                    <td>
                        <div class="action-icons align-items-center">
                            <a href="{{ route('kas_keluar.show', $item->id_kas_keluar) }}" class="text-primary" title="Detail">
                                <i class="fa-regular fa-eye"></i>
                            </a>

                            @if($isManual)
                                <form action="{{ route('kas_keluar.destroy', $item->id_kas_keluar) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted ms-1" style="font-size: 11px;" title="Terkunci (Sistem)"><i class="fa-solid fa-lock"></i></span>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada catatan pengeluaran kas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($ringkasan['jumlah_semua'] > 0)
    @php
        $namaBulan = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                      '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                      '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];

        if (request('tanggal')) {
            $periode = \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d F Y');
        } elseif (request('bulan') && request('tahun')) {
            $periode = ($namaBulan[request('bulan')] ?? '') . ' ' . request('tahun');
        } elseif (request('bulan')) {
            $periode = 'Bulan ' . ($namaBulan[request('bulan')] ?? '') . ' (semua tahun)';
        } elseif (request('tahun')) {
            $periode = 'Tahun ' . request('tahun');
        } else {
            $periode = 'Semua periode';
        }

        $persenOtomatis = $ringkasan['total'] > 0 ? round($ringkasan['otomatis'] / $ringkasan['total'] * 100) : 0;
        $persenManual = $ringkasan['total'] > 0 ? 100 - $persenOtomatis : 0;
    @endphp

    <div class="bg-light border-top p-3 d-flex justify-content-between align-items-center" style="font-size: 13px;">
        <div>
            <span class="text-muted">Total Pengeluaran ({{ $periode }}):</span>
            <strong class="text-danger ms-1 fs-6">Rp {{ number_format($ringkasan['total'], 0, ',', '.') }}</strong>
            <span class="text-muted ms-2">({{ number_format($ringkasan['jumlah_semua'], 0, ',', '.') }} catatan)</span>
            
            @if(request()->filled('search'))
                <span class="text-muted ms-1">&middot; Pencarian "{{ request('search') }}"</span>
            @endif
        </div>
        <div class="text-muted">
            <span class="me-3"><i class="fa-solid fa-circle text-info" style="font-size: 8px; vertical-align: middle;"></i> Sistem: Rp {{ number_format($ringkasan['otomatis'], 0, ',', '.') }}</span>
            <span><i class="fa-solid fa-circle text-success" style="font-size: 8px; vertical-align: middle;"></i> Manual: Rp {{ number_format($ringkasan['manual'], 0, ',', '.') }}</span>
        </div>
    </div>
    @endif

    <!-- Pagination -->
    <div class="bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
        @if($kasKeluars->count() > 0)
            <div>Menampilkan <strong>{{ $kasKeluars->firstItem() }}-{{ $kasKeluars->lastItem() }}</strong> dari <strong>{{ $kasKeluars->total() }}</strong> pengeluaran</div>
            <div>
                {{ $kasKeluars->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div>Menampilkan 0 data</div>
        @endif
    </div>
</div>


@endsection