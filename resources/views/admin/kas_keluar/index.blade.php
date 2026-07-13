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
    
    .action-icons button.text-danger:hover {
        color: #dc2626 !important;
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
<div class="mb-4">
    <div class="text-muted" style="font-size: 13px; margin-bottom: 10px;">
        Keuangan &rsaquo; <strong class="text-primary" style="color: #1a5ca6 !important;">Kas Keluar</strong>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 fw-bold mb-0 text-dark">Kas Keluar (Uang Keluar)</h1>
            <p class="text-muted mb-0" style="font-size: 14px;">Kelola pengeluaran kas operasional cabang seperti listrik, air, dan belanja kebutuhan toko.</p>
        </div>
        @if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super')
        <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fa-solid fa-file-invoice-dollar me-1"></i> Catat Kas Keluar
        </button>
        @endif
    </div>
</div>

<!-- Action Bar -->
<div class="action-bar">
    <form action="{{ route('kas_keluar.index') }}" method="GET" class="d-flex gap-2 m-0 flex-wrap">
        <div class="search-input">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" name="search" class="form-control" placeholder="Cari keterangan..." value="{{ request('search') }}">
        </div>
        @if(auth()->user()->role === 'super')
            <select name="id_cabang" class="form-select" style="width: 200px;" onchange="this.form.submit()">
                <option value="">-- Semua Cabang --</option>
                @foreach($cabangs as $cabang)
                    <option value="{{ $cabang->id_cabang }}" {{ request('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                @endforeach
            </select>
        @endif
        <button type="submit" class="btn btn-outline-secondary px-3" style="border-radius: 8px;">Filter</button>
        @if(request()->filled('search') || request()->filled('id_cabang'))
            <a href="{{ route('kas_keluar.index') }}" class="btn btn-light border px-3" style="border-radius: 8px;">Reset</a>
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
                <th>Keterangan / Keperluan</th>
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
                    <td>{{ $item->keterangan }}</td>
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
                        @if($isManual)
                            <div class="action-icons">
                                <form action="{{ route('kas_keluar.destroy', $item->id_kas_keluar) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-muted" style="font-size: 11px;">Terkunci</span>
                        @endif
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada catatan pengeluaran kas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

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

<!-- Modal Tambah Kas Keluar -->
@if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super')
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <form action="{{ route('kas_keluar.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Catat Kas Keluar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    @if(auth()->user()->role === 'super')
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Cabang <span class="text-danger">*</span></label>
                        <select name="id_cabang" class="form-select" required>
                            <option value="">-- Pilih Cabang --</option>
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Jumlah Pengeluaran (Rupiah) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-light text-muted fw-bold">Rp</span>
                            <input type="number" name="jumlah_pengeluaran" class="form-control border-start-0" placeholder="Contoh: 150000" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Keperluan / Keterangan <span class="text-danger">*</span></label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Bayar tagihan listrik cabang Juli 2026 atau Pembelian sapu & alat pembersih toko" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Tanggal Catat (Opsional)</label>
                        <input type="datetime-local" name="tanggal" class="form-control" value="{{ date('Y-m-d\TH:i') }}">
                        <div class="form-text text-muted" style="font-size: 11px;">Biarkan kosong untuk mencatat dengan waktu saat ini.</div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 8px;">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
