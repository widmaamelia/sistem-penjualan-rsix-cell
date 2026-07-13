@extends('layouts.admin')

@section('title', 'Riwayat Stok Opname')

@section('styles')
<style>
    .badge-status-pending { background-color: #fef3c7; color: #d97706; }
    .badge-status-approved { background-color: #dcfce7; color: #166534; }
    .badge-status-rejected { background-color: #fee2e2; color: #991b1b; }
    .badge-status { padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 11px; text-transform: uppercase; }
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

<div class="d-flex justify-content-end align-items-center mb-3">
    @if(auth()->user()->role === 'admin cabang')
        <a href="{{ route('stok_opname.create') }}" class="btn btn-primary" style="background-color: #1a5ca6;">
            <i class="fa-solid fa-plus me-1"></i> Buat Stok Opname
        </a>
    @endif
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">ID</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">TANGGAL</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">CABANG</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">PEMBUAT</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">STATUS</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($opnames as $opname)
                    <tr>
                        <td class="px-4 fw-bold">#{{ str_pad($opname->id_stok_opname, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4">{{ \Carbon\Carbon::parse($opname->tanggal_opname)->format('d M Y') }}</td>
                        <td class="px-4 text-primary fw-medium">{{ $opname->cabang->nama_cabang }}</td>
                        <td class="px-4">{{ $opname->user->name }}</td>
                        <td class="px-4">
                            <span class="badge-status badge-status-{{ $opname->status }}">
                                {{ $opname->status }}
                            </span>
                        </td>
                        <td class="px-4">
                            <a href="{{ route('stok_opname.show', $opname->id_stok_opname) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="fa-regular fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat stok opname.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($opnames->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $opnames->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
