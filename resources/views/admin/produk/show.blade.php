@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')

<div class="mb-4">
    <a href="{{ route('produk.index') }}" class="btn btn-light bg-white" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>

<div class="form-card p-3 bg-white" style="border-radius: 12px; border: 1px solid #e5e7eb;">
    <div class="row">
        <!-- FOTO PRODUK -->
        <div class="col-md-2 mb-3 text-center">
            @if($produk->foto_produk)
                <img src="{{ $produk->foto_produk }}" alt="Foto Produk" class="mx-auto" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 1px solid #e5e7eb;">
            @else
                <div class="mx-auto d-flex flex-column align-items-center justify-content-center" style="width: 120px; height: 120px; border-radius: 10px; background-color: #f8fafc; border: 2px dashed #cbd5e1;">
                    <i class="fa-regular fa-image text-muted" style="font-size: 28px; margin-bottom: 5px;"></i>
                    <span class="text-muted" style="font-size: 10px;">Tidak Ada Foto</span>
                </div>
            @endif
        </div>

        <!-- INFO PRODUK -->
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 16px;">{{ $produk->nama_produk }}</h5>
                    <p class="text-muted mb-2" style="font-size: 12px;">{{ $produk->kategori->nama_kategori ?? '-' }}</p>
                    <span class="badge {{ $produk->status == 'aktif' ? 'bg-success' : 'bg-secondary' }} px-2 py-1" style="font-size: 10px;">{{ strtoupper($produk->status) }}</span>
                </div>
                <a href="{{ route('produk.edit', $produk->id_produk) }}" class="btn btn-sm btn-primary" style="background-color: #1a5ca6; font-size: 11px;">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Data
                </a>
            </div>
            
            <div class="row mt-3 p-2 rounded" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                <div class="col-md-3 col-6 mb-2 mb-md-0 border-end">
                    <span class="d-block text-muted" style="font-size: 10px; text-transform: uppercase;">SKU</span>
                    <strong style="font-size: 12px; color: #111827;">{{ $produk->sku ?? '-' }}</strong>
                </div>
                <div class="col-md-3 col-6 mb-2 mb-md-0 border-end">
                    <span class="d-block text-muted" style="font-size: 10px; text-transform: uppercase;">Barcode / IMEI</span>
                    <strong style="font-size: 12px; color: #111827;">{{ $produk->barcode_imei ?? '-' }}</strong>
                </div>
                <div class="col-md-3 col-6 border-end">
                    <span class="d-block text-muted" style="font-size: 10px; text-transform: uppercase;">Harga Beli Dasar</span>
                    <strong style="font-size: 12px; color: #111827;">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</strong>
                </div>
                <div class="col-md-3 col-6">
                    <span class="d-block text-muted" style="font-size: 10px; text-transform: uppercase;">Harga Jual (Normal)</span>
                    <strong class="text-primary" style="font-size: 14px;">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-3" style="border-color: #f3f4f6;">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="text-uppercase fw-bold m-0" style="font-size:11px; color: #1a5ca6; letter-spacing:0.5px;">Ketersediaan Stok di Cabang</h6>
        @php $totalStok = $produk->stokCabangs->sum('stok_sekarang'); @endphp
        <div class="badge-total" style="background-color: #f0f7ff; color: #1a5ca6; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; border: 1px solid #bae6fd;">
            Total Seluruh Stok: <span>{{ $totalStok }} Unit</span>
        </div>
    </div>

    <div class="row">
        @forelse($produk->stokCabangs as $stok)
            <div class="col-md-2 col-sm-4 col-6 mb-2">
                <div class="p-2 h-100 d-flex flex-column justify-content-center" style="border: 1px solid #e5e7eb; border-radius: 6px; background-color: #ffffff; box-shadow: 0 1px 2px rgba(0,0,0,0.02);">
                    <div class="text-muted text-truncate text-uppercase" style="font-size: 9px; margin-bottom: 2px; font-weight: 600; letter-spacing: 0.3px;" title="{{ $stok->cabang->nama_cabang ?? '-' }}">
                        <i class="fa-solid fa-store me-1"></i> {{ $stok->cabang->nama_cabang ?? '-' }}
                    </div>
                    <div class="fw-bold {{ $stok->stok_sekarang > 0 ? 'text-dark' : 'text-danger' }}" style="font-size: 13px;">
                        {{ $stok->stok_sekarang }} <span style="font-size: 10px; font-weight: normal;">Unit</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-3 text-muted" style="font-size: 12px;">Belum ada sebaran stok cabang.</div>
        @endforelse
    </div>
</div>

@endsection
