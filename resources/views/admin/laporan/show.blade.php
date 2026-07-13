@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="m-0 fw-bold">Detail Transaksi #{{ $transaksi->no_transaksi }}</h4>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3 text-uppercase text-muted" style="font-size: 12px;">Informasi Transaksi</h6>
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td class="fw-bold text-end">{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Kasir</td>
                        <td class="fw-bold text-end">{{ $transaksi->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Cabang</td>
                        <td class="fw-bold text-end text-primary">{{ $transaksi->cabang->nama_cabang ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode Bayar</td>
                        <td class="fw-bold text-end text-uppercase">{{ $transaksi->metode_bayar }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 fw-bold">Rincian Pembelian</h6>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-2 px-4 text-muted" style="font-size: 12px;">PRODUK / ITEM</th>
                            <th class="py-2 px-4 text-muted text-center" style="font-size: 12px;">QTY</th>
                            <th class="py-2 px-4 text-muted text-end" style="font-size: 12px;">HARGA SATUAN</th>
                            <th class="py-2 px-4 text-muted text-end" style="font-size: 12px;">SUB TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->detailTransaksis as $d)
                            <tr>
                                <td class="px-4">
                                    <span class="fw-bold">{{ $d->produk->nama_produk ?? $d->nama_item_manual }}</span><br>
                                    @if($d->nomor_tujuan)
                                        <small class="text-muted">No: {{ $d->nomor_tujuan }}</small>
                                    @endif
                                </td>
                                <td class="px-4 text-center">{{ $d->qty }}</td>
                                <td class="px-4 text-end">Rp {{ number_format($d->harga_jual_realtime, 0, ',', '.') }}</td>
                                <td class="px-4 text-end fw-bold">Rp {{ number_format($d->sub_total, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td colspan="3" class="text-end py-3 px-4 fw-bold">Total Pembayaran:</td>
                            <td class="text-end py-3 px-4 fw-bold fs-5 text-primary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end py-2 px-4 text-muted">Uang Tunai (Diterima):</td>
                            <td class="text-end py-2 px-4 fw-bold">Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end py-2 px-4 text-muted">Kembalian:</td>
                            <td class="text-end py-2 px-4 fw-bold text-success">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
