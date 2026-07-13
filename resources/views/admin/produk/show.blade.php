@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="m-0 fw-bold">Detail Produk</h4>
</div>

<div class="row">
    <!-- Profil Produk Singkat -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 rounded-3 text-center p-4">
            <img src="{{ $produk->foto_produk ?? 'https://via.placeholder.com/200' }}" alt="Foto Produk" class="img-fluid rounded mb-3 mx-auto" style="max-height: 200px; object-fit: cover;">
            <h5 class="fw-bold text-dark mb-1">{{ $produk->nama_produk }}</h5>
            <p class="text-muted mb-2">{{ $produk->kategori->nama_kategori ?? '-' }}</p>
            
            <div class="mt-2">
                @if($produk->status == 'aktif')
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Aktif</span>
                @else
                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">Non-aktif</span>
                @endif
            </div>

            <hr class="my-4">
            
            <a href="{{ route('produk.edit', $produk->id_produk) }}" class="btn btn-primary w-100" style="background-color: #1a5ca6;">
                <i class="fa-solid fa-pen-to-square me-2"></i> Edit Data
            </a>
        </div>
    </div>

    <!-- Informasi Detail & Stok -->
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 fw-bold">Informasi Barang</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted" style="width: 30%;">SKU</td>
                        <td class="fw-bold">{{ $produk->sku ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Barcode / IMEI</td>
                        <td class="fw-bold">{{ $produk->barcode_imei ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Harga Beli Dasar</td>
                        <td class="fw-bold">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Harga Jual (Normal)</td>
                        <td class="fw-bold text-primary fs-5">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 fw-bold">Ketersediaan Stok di Cabang</h6>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-2 px-4 text-muted" style="font-size: 12px;">LOKASI CABANG</th>
                            <th class="py-2 px-4 text-muted text-center" style="font-size: 12px;">SISA STOK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalStok = 0; @endphp
                        @forelse($produk->stokCabangs as $stok)
                            @php $totalStok += $stok->stok_sekarang; @endphp
                            <tr>
                                <td class="px-4 fw-bold">{{ $stok->cabang->nama_cabang ?? '-' }}</td>
                                <td class="px-4 text-center">
                                    <span class="badge {{ $stok->stok_sekarang > 0 ? 'bg-info' : 'bg-danger' }} rounded-pill px-3 py-2">
                                        {{ $stok->stok_sekarang }} Unit
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">Belum ada sebaran stok cabang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td class="text-end py-3 px-4 fw-bold text-muted">Total Seluruh Stok:</td>
                            <td class="text-center py-3 px-4 fw-bold fs-5 text-dark">{{ $totalStok }} Unit</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
