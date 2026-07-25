@extends('layouts.admin')

@section('title', 'Detail Stok Opname')

@section('styles')
<style>
    .badge-status-pending { background-color: #fef3c7; color: #d97706; }
    .badge-status-approved { background-color: #dcfce7; color: #166534; }
    .badge-status-rejected { background-color: #fee2e2; color: #991b1b; }
    .badge-status { padding: 6px 16px; border-radius: 20px; font-weight: 600; font-size: 13px; text-transform: uppercase; }
</style>
@endsection

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('stok_opname.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h4 class="m-0 fw-bold">Detail Stok Opname</h4>
    </div>
    
    @if(auth()->user()->role === 'super' && $opname->status === 'pending')
        <div class="d-flex gap-2">
            <form action="{{ route('stok_opname.reject', $opname->id_stok_opname) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak stok opname ini?');">
                @csrf
                <button type="submit" class="btn btn-danger fw-bold"><i class="fa-solid fa-xmark me-1"></i> Reject</button>
            </form>
            <form action="{{ route('stok_opname.approve', $opname->id_stok_opname) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui stok opname ini? Stok pada sistem akan langsung berubah mengikuti stok fisik.');">
                @csrf
                <button type="submit" class="btn btn-success fw-bold"><i class="fa-solid fa-check me-1"></i> Approve</button>
            </form>
        </div>
    @endif
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
                <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 13px;">Informasi Opname</h6>
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width: 150px;">Tanggal</td>
                        <td class="fw-bold">: {{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Cabang</td>
                        <td class="fw-bold text-primary">: {{ $opname->cabang->nama_cabang }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Pembuat</td>
                        <td class="fw-bold">: {{ $opname->user->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Keterangan Umum</td>
                        <td class="fw-medium">: {{ $opname->keterangan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column justify-content-center align-items-center">
            <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 13px;">Status Saat Ini</h6>
            <div class="badge-status badge-status-{{ $opname->status }} fs-5 py-2 px-4">
                {{ $opname->status }}
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold">Detail Item Penyesuaian</h6>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4" style="font-size: 13px;">PRODUK</th>
                    <th class="py-3 px-4 text-center" style="font-size: 13px;">STOK SISTEM</th>
                    <th class="py-3 px-4 text-center" style="font-size: 13px;">STOK FISIK</th>
                    <th class="py-3 px-4 text-center" style="font-size: 13px;">SELISIH</th>
                    <th class="py-3 px-4" style="font-size: 13px;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opname->details as $detail)
                    <tr>
                        <td class="px-4">
                            <span class="text-muted" style="font-size: 11px;">{{ $detail->produk->kode_produk }}</span><br>
                            <span class="fw-bold">{{ $detail->produk->nama_produk }}</span>
                        </td>
                        <td class="px-4 text-center text-muted fw-bold">{{ $detail->stok_sistem }}</td>
                        <td class="px-4 text-center fs-6 fw-bold text-dark">{{ $detail->stok_fisik }}</td>
                        <td class="px-4 text-center">
                            @if($detail->selisih > 0)
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">+{{ $detail->selisih }}</span>
                            @elseif($detail->selisih < 0)
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">{{ $detail->selisih }}</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">0</span>
                            @endif
                        </td>
                        <td class="px-4 text-muted">{{ $detail->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Tidak ada item yang diinput.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
