@extends('layouts.admin')

@section('title', 'Catat Kas Keluar Baru')

@section('content')
<!-- Header -->
<div class="mb-4">
    <a href="{{ route('kas_keluar.index') }}" class="btn btn-light bg-white" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>

<div class="form-card p-3 bg-white" style="border-radius: 12px; border: 1px solid #e5e7eb;">
    @if ($errors->any())
        <div class="alert alert-danger" style="font-size: 13px; padding: 10px; margin-bottom: 15px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kas_keluar.store') }}" method="POST">
        @csrf
        
        <div class="row mb-2">
            @if(auth()->user()->role === 'super')
            <div class="col-md-6 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Cabang <span class="text-danger">*</span></label>
                <select name="id_cabang" class="form-select form-select-sm" required>
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id_cabang }}">{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-2">
            @else
            <div class="col-md-12 mb-2">
            @endif
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Jumlah Pengeluaran (Rupiah) <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light text-muted fw-bold">Rp</span>
                    <input type="number" name="jumlah_pengeluaran" class="form-control" placeholder="Contoh: 150000" min="0" required>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Keperluan / Keterangan <span class="text-danger">*</span></label>
                <textarea name="keterangan" class="form-control form-control-sm" rows="2" placeholder="Contoh: Bayar tagihan listrik cabang Juli 2026 atau Pembelian sapu & alat pembersih toko" required></textarea>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-6 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Tanggal Catat (Opsional)</label>
                <input type="datetime-local" name="tanggal" class="form-control form-control-sm" value="{{ date('Y-m-d\TH:i') }}">
                <div class="form-text text-muted mt-1" style="font-size: 10px;">Biarkan kosong untuk mencatat waktu saat ini.</div>
            </div>
        </div>

        <hr class="my-3" style="border-color: #f3f4f6;">
        
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('kas_keluar.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 6px; font-weight: 500;">Batal</a>
            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500;"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Catatan</button>
        </div>
    </form>
</div>
@endsection
