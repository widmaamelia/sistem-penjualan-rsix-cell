@extends('layouts.admin')

@section('title', isset($cabangSpesifik) ? 'Detail Laporan: ' . $cabangSpesifik->nama_cabang : 'Laporan Penjualan')

@section('content')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@if(isset($cabangSpesifik))
<div class="mb-4">
    <a href="{{ route('laporan.index') }}" class="btn btn-light" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px;" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>
@endif

<!-- Ringkasan Dashboard -->
<div class="row g-2 mb-3">
    <div class="col-lg col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-secondary text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Transaksi</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px;">{{ number_format($totalTransaksi, 0, ',', '.') }}</h5>
                </div>
                <div class="fs-4 text-white-50">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-success text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Uang Masuk</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px;">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</h5>
                </div>
                <div class="fs-4 text-white-50">
                    <i class="fa-solid fa-circle-arrow-down"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-danger text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Pengeluaran Operasional</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px;">Rp {{ number_format($totalOperasional, 0, ',', '.') }}</h5>
                    <small class="text-white-50" style="font-size: 10px;">Listrik, gaji, ATK, dll</small>
                </div>
                <div class="fs-4 text-white-50">
                    <i class="fa-solid fa-circle-arrow-up"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 text-white h-100" style="background-color: #6f42c1;">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Pembelian Barang Stok</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px;">Rp {{ number_format($totalPembelianStok, 0, ',', '.') }}</h5>
                    <small class="text-white-50" style="font-size: 10px;">Restock &amp; stok opname</small>
                </div>
                <div class="fs-4 text-white-50">
                    <i class="fa-solid fa-boxes-stacked"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm rounded-3 bg-info text-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 text-uppercase fw-bold mb-1" style="font-size: 11px;">Total Laba Kotor</h6>
                    <h5 class="m-0 fw-bold" style="font-size: 18px;">Rp {{ number_format($labaKotor, 0, ',', '.') }}</h5>
                </div>
                <div class="fs-4 text-white-50">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex align-items-center mb-3">
    <form action="{{ route('laporan.index') }}" method="GET" class="d-flex gap-2 m-0 flex-wrap align-items-center w-100">
        @if(isset($cabangSpesifik))
            <input type="hidden" name="id_cabang" value="{{ $cabangSpesifik->id_cabang }}">
        @endif
        
        <input type="text" name="date_range" id="date_range" class="form-control" style="width: 250px; border-radius: 6px; font-size: 13.5px; padding: 6px 12px;" placeholder="Rentang Tanggal" value="{{ request('date_range') }}">

        @if(isset($karyawans) && $karyawans->count() > 0)
        <select name="id_user" class="form-select" style="width: 160px; border-radius: 6px; font-size: 13.5px; padding: 6px 32px 6px 12px;" title="Filter berdasarkan Karyawan">
            <option value="">-- Semua Karyawan --</option>
            @foreach($karyawans as $karyawan)
                <option value="{{ $karyawan->id_user }}" {{ request('id_user') == $karyawan->id_user ? 'selected' : '' }}>
                    {{ $karyawan->name }}
                </option>
            @endforeach
        </select>
        @endif

        <button type="submit" class="btn btn-outline-secondary" style="border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Filter</button>
        @if(request()->hasAny(['date_range', 'id_user']))
            <a href="{{ route('laporan.index', isset($cabangSpesifik) ? ['id_cabang' => $cabangSpesifik->id_cabang] : []) }}" class="btn btn-light border" style="border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Reset</a>
        @endif
    </form>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold" style="font-size: 15px;">Riwayat Transaksi (Uang Masuk)</h5>
        <div class="btn-group">
            <a href="{{ route('laporan.print', request()->all()) }}" target="_blank" class="btn btn-outline-secondary" style="font-size: 12px; padding: 4px 10px;">
                <i class="fa-solid fa-print"></i> Print
            </a>
            <a href="{{ route('laporan.export.pdf', request()->all()) }}" class="btn btn-outline-danger" style="font-size: 12px; padding: 4px 10px;">
                <i class="fa-solid fa-file-pdf"></i> PDF
            </a>
            <a href="{{ route('laporan.export.excel', request()->all()) }}" class="btn btn-outline-success" style="font-size: 12px; padding: 4px 10px;">
                <i class="fa-solid fa-file-excel"></i> Excel
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle table-hover">
            <thead class="bg-light">
                <tr>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px; width: 40px;">NO</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">PRODUK</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">TANGGAL</th>
                    @if(auth()->user()->role === 'super')
                        <th class="py-2 px-3 text-muted" style="font-size: 11px;">CABANG</th>
                    @endif
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">KASIR</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">METODE</th>
                    <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">MODAL</th>
                    <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">LABA</th>
                    <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">TOTAL</th>
                    <th class="py-2 px-3 text-muted" style="font-size: 11px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                    @php
                        $modalTransaksi = 0;
                        foreach ($t->detailTransaksis as $d) {
                            $modalTransaksi += $d->harga_beli_realtime * $d->qty;
                        }
                        $labaTransaksi = $t->total_harga - $modalTransaksi;
                    @endphp
                    <tr>
                        <td class="px-3 py-2 text-muted" style="font-size: 12px;">{{ $transaksis->firstItem() + $loop->index }}</td>
                        <td class="px-3 py-2">
                            @foreach($t->detailTransaksis as $d)
                                @php
                                    $labaBaris = ($d->harga_jual_realtime - $d->harga_beli_realtime) * $d->qty;
                                @endphp
                                <div style="font-size: 12px; font-weight: 600;" class="text-dark">
                                    {{ $d->produk->nama_produk ?? $d->nama_item_manual ?? 'Produk' }}
                                    <span class="text-muted">(x{{ $d->qty }})</span>
                                </div>
                                <div class="text-muted mb-1" style="font-size: 10px;">
                                    Jual Rp {{ number_format($d->harga_jual_realtime, 0, ',', '.') }}
                                    &minus; Beli Rp {{ number_format($d->harga_beli_realtime, 0, ',', '.') }}
                                    = <span class="{{ $labaBaris >= 0 ? 'text-success' : 'text-danger' }} fw-bold">Laba Rp {{ number_format($labaBaris, 0, ',', '.') }}</span>
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
                        <td class="px-3 py-2 text-end text-muted" style="font-size: 12px;">Rp {{ number_format($modalTransaksi, 0, ',', '.') }}</td>
                        <td class="px-3 py-2 text-end fw-bold {{ $labaTransaksi >= 0 ? 'text-success' : 'text-danger' }}" style="font-size: 12px;">
                            Rp {{ number_format($labaTransaksi, 0, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 text-end fw-bold text-dark" style="font-size: 12px;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        <td class="px-3 py-2">
                            <a href="{{ route('laporan.show', $t->id_transaksi) }}" class="btn btn-sm btn-outline-info py-0 px-2" style="font-size: 11px;">
                                <i class="fa-regular fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'super' ? '10' : '9' }}" class="text-center py-4 text-muted" style="font-size: 12px;">Belum ada data transaksi yang cocok dengan filter.</td>
                    </tr>
                @endforelse
            </tbody>
            @if($totalTransaksi > 0)
            @php
                // $totalOmzet & $labaKotor sudah dihitung dari SELURUH transaksi
                // hasil filter, bukan hanya 15 baris yang tampil di halaman ini.
                $totalModal = $totalOmzet - $labaKotor;
                $marginPersen = $totalOmzet > 0 ? $labaKotor / $totalOmzet * 100 : 0;
            @endphp
            <tfoot class="bg-light">
                <tr>
                    <td colspan="{{ auth()->user()->role === 'super' ? '6' : '5' }}" class="px-3 py-2 text-end fw-bold" style="font-size: 12px;">
                        TOTAL KESELURUHAN
                        <div class="text-muted fw-normal" style="font-size: 10px;">
                            {{ number_format($totalTransaksi, 0, ',', '.') }} transaksi
                            @if($transaksis->hasPages())
                                (termasuk halaman lain)
                            @endif
                        </div>
                    </td>
                    <td class="px-3 py-2 text-end fw-bold text-muted" style="font-size: 13px;">
                        Rp {{ number_format($totalModal, 0, ',', '.') }}
                    </td>
                    <td class="px-3 py-2 text-end fw-bold {{ $labaKotor >= 0 ? 'text-success' : 'text-danger' }}" style="font-size: 13px;">
                        Rp {{ number_format($labaKotor, 0, ',', '.') }}
                        <div class="text-muted fw-normal" style="font-size: 10px;">margin {{ number_format($marginPersen, 1, ',', '.') }}%</div>
                    </td>
                    <td class="px-3 py-2 text-end fw-bold text-dark" style="font-size: 13px;">
                        Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
    @if($transaksis->hasPages())
        <div class="card-footer bg-white border-top py-2 px-3">
            {{ $transaksis->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- Rincian Uang Keluar, dipisah per jenis -->
<div class="row g-3 mt-0">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header bg-white py-2">
                <h6 class="m-0 fw-bold"><i class="fa-solid fa-receipt text-danger me-2"></i> Pengeluaran Operasional</h6>
                <small class="text-muted" style="font-size: 11px;">Listrik, gaji, ATK, dan kebutuhan toko</small>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-2 px-3 text-muted" style="font-size: 11px;">TANGGAL</th>
                            <th class="py-2 px-3 text-muted" style="font-size: 11px;">KETERANGAN</th>
                            <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">NOMINAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($operasionals as $kk)
                            <tr>
                                <td class="px-3 py-2 text-nowrap" style="font-size: 12px;">{{ \Carbon\Carbon::parse($kk->tanggal)->format('d M Y H:i') }}</td>
                                <td class="px-3 py-2 text-wrap" style="font-size: 12px;">{{ $kk->keterangan }}</td>
                                <td class="px-3 py-2 text-end fw-bold text-danger text-nowrap" style="font-size: 12px;">Rp {{ number_format($kk->jumlah_pengeluaran, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted" style="font-size: 12px;">Belum ada pengeluaran operasional pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td colspan="2" class="px-3 py-2 text-end fw-bold" style="font-size: 12px;">TOTAL OPERASIONAL</td>
                            <td class="px-3 py-2 text-end fw-bold text-danger text-nowrap" style="font-size: 13px;">Rp {{ number_format($totalOperasional, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header bg-white py-2">
                <h6 class="m-0 fw-bold"><i class="fa-solid fa-boxes-stacked me-2" style="color: #6f42c1;"></i> Pembelian Barang Stok</h6>
                <small class="text-muted" style="font-size: 11px;">Restock dan penyesuaian stok opname</small>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-2 px-3 text-muted" style="font-size: 11px;">TANGGAL</th>
                            <th class="py-2 px-3 text-muted" style="font-size: 11px;">KETERANGAN</th>
                            <th class="py-2 px-3 text-muted text-end" style="font-size: 11px;">NOMINAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelianStoks as $kk)
                            <tr>
                                <td class="px-3 py-2 text-nowrap" style="font-size: 12px;">{{ \Carbon\Carbon::parse($kk->tanggal)->format('d M Y H:i') }}</td>
                                <td class="px-3 py-2 text-wrap" style="font-size: 12px;">{{ $kk->keterangan }}</td>
                                <td class="px-3 py-2 text-end fw-bold text-nowrap" style="font-size: 12px; color: #6f42c1;">Rp {{ number_format($kk->jumlah_pengeluaran, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted" style="font-size: 12px;">Belum ada pembelian stok pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td colspan="2" class="px-3 py-2 text-end fw-bold" style="font-size: 12px;">TOTAL PEMBELIAN STOK</td>
                            <td class="px-3 py-2 text-end fw-bold text-nowrap" style="font-size: 13px; color: #6f42c1;">Rp {{ number_format($totalPembelianStok, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d M Y",
            placeholder: "Mulai s/d Akhir"
        });
    });
</script>
@endsection