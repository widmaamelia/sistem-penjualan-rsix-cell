@extends('layouts.admin')

@section('title', 'Riwayat Stok Produk')

@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('stok.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h4 class="m-0 fw-bold">Riwayat Stok: {{ $produk->nama_produk }}</h4>
        <small class="text-muted">SKU: {{ $produk->sku }}</small>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="{{ route('stok.history', $produk->id_produk) }}" method="GET" class="row g-3 align-items-end">
            @if(auth()->user()->role === 'super')
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Cabang</label>
                <select name="id_cabang" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Cabang</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id_cabang }}" {{ request('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            @else
            <div class="col-md-12">
                <p class="mb-0 text-muted">Menampilkan riwayat stok khusus untuk cabang Anda.</p>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="table-responsive">
        <table class="table mb-0 align-middle table-hover">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 180px;">TANGGAL & WAKTU</th>
                    @if(auth()->user()->role === 'super')
                        <th class="py-3 px-4 text-muted" style="font-size: 12px;">CABANG</th>
                    @endif
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">PENGGUNA</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">JENIS TRANSAKSI</th>
                    <th class="py-3 px-4 text-muted text-center" style="font-size: 12px;">PERUBAHAN</th>
                    <th class="py-3 px-4 text-muted text-center" style="font-size: 12px;">STOK AKHIR</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="px-4 text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</td>
                        @if(auth()->user()->role === 'super')
                            <td class="px-4 fw-bold">{{ $log->cabang->nama_cabang ?? '-' }}</td>
                        @endif
                        <td class="px-4">{{ $log->user->name ?? 'Sistem' }}</td>
                        <td class="px-4">
                            @if(str_contains(strtolower($log->jenis_transaksi), 'masuk') || str_contains(strtolower($log->jenis_transaksi), 'penambahan'))
                                <span class="badge bg-success bg-opacity-10 text-success text-uppercase">{{ $log->jenis_transaksi }}</span>
                            @elseif(str_contains(strtolower($log->jenis_transaksi), 'keluar') || str_contains(strtolower($log->jenis_transaksi), 'pengurangan') || str_contains(strtolower($log->jenis_transaksi), 'penjualan'))
                                <span class="badge bg-danger bg-opacity-10 text-danger text-uppercase">{{ $log->jenis_transaksi }}</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary text-uppercase">{{ $log->jenis_transaksi }}</span>
                            @endif
                        </td>
                        <td class="px-4 text-center fw-bold fs-5 {{ $log->stok_sesudah > $log->stok_sebelum ? 'text-success' : ($log->stok_sesudah < $log->stok_sebelum ? 'text-danger' : 'text-muted') }}">
                            @if($log->stok_sesudah > $log->stok_sebelum)
                                +{{ $log->qty }}
                            @elseif($log->stok_sesudah < $log->stok_sebelum)
                                -{{ $log->qty }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="px-4 text-center fw-bold">{{ $log->stok_sesudah }}</td>
                        <td class="px-4 text-muted" style="font-size: 13px;">{{ $log->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'super' ? '7' : '6' }}" class="text-center py-5 text-muted">Belum ada riwayat pergerakan stok untuk produk ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
