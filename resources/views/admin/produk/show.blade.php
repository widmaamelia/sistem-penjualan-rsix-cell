@extends('layouts.admin')

@section('title', 'Detail Produk - ' . $produk->nama_produk)

@section('styles')
<style>
    .header-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .back-btn {
        color: #6b7280;
        text-decoration: none;
        transition: color 0.2s;
    }

    .back-btn:hover {
        color: #1a5ca6;
    }

    .detail-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .info-label {
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 500;
        color: #1f2937;
        margin-bottom: 20px;
    }

    .badge-status {
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }
    
    .badge-status-aktif { background-color: #dcfce7; color: #166534; }
    .badge-status-nonaktif { background-color: #e5e7eb; color: #4b5563; }
</style>
@endsection

@section('content')

<!-- Header Action -->
<div class="header-action">
    <h1 class="page-title">
        <a href="{{ route('produk.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        Detail Produk
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('produk.edit', $produk->id_produk) }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 500; background-color: #1a5ca6; border-color: #1a5ca6;">
            <i class="fa-solid fa-pen-to-square me-2"></i>Edit Produk
        </a>
    </div>
</div>

<div class="detail-card">
    <div class="row g-5">
        <!-- Kolom Kiri: Foto dan Status -->
        <div class="col-md-4 text-center">
            <div class="p-3 border rounded-3 bg-light mb-4">
                <img src="{{ $produk->foto_produk ?? 'https://via.placeholder.com/300' }}" alt="{{ $produk->nama_produk }}" class="img-fluid rounded" style="max-height: 300px; width: 100%; object-fit: cover;">
            </div>
            
            @if($produk->status == 'aktif')
                <div class="badge-status badge-status-aktif w-100 py-2">Status: Aktif</div>
            @else
                <div class="badge-status badge-status-nonaktif w-100 py-2">Status: Non-aktif</div>
            @endif
        </div>

        <!-- Kolom Kanan: Detail Informasi -->
        <div class="col-md-8">
            <h2 class="fw-bold text-dark mb-1">{{ $produk->nama_produk }}</h2>
            <p class="text-muted mb-4 fs-5"><i class="fa-solid fa-tags me-2"></i> {{ $produk->kategori->nama_kategori ?? '-' }}</p>
            
            <hr class="mb-4">

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-label">SKU Produk</div>
                    <div class="info-value">{{ $produk->sku ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Barcode / IMEI</div>
                    <div class="info-value">{{ $produk->barcode_imei ?? '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Harga Beli</div>
                    <div class="info-value text-muted">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="info-label">Harga Jual (Konsumen)</div>
                    <div class="info-value text-primary fs-4 fw-bold">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
                </div>
            </div>

            <hr class="my-4">

            <div class="info-label mb-3">Ketersediaan Stok Fisik per Cabang</div>
            <div class="table-responsive rounded border">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="padding: 12px 20px;">Nama Cabang</th>
                            <th class="text-center" style="width: 150px; padding: 12px 20px;">Kuantitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalStok = 0; @endphp
                        @forelse($produk->stokCabangs as $stok)
                            @php $totalStok += $stok->stok_sekarang; @endphp
                            <tr>
                                <td style="padding: 12px 20px; font-weight: 500;">{{ $stok->cabang->nama_cabang ?? '-' }}</td>
                                <td class="text-center fw-bold" style="padding: 12px 20px;">
                                    {{ $stok->stok_sekarang }} Unit
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-4">Belum ada data distribusi stok cabang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th class="text-end py-3 px-4">TOTAL KESELURUHAN:</th>
                            <th class="text-center py-3 px-4 fs-5 text-primary">{{ $totalStok }} Unit</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
