@extends('layouts.admin')

@section('title', 'Edit Cabang - ' . $cabang->nama_cabang)

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

    .form-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 30px;
        max-width: 800px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .required-star {
        color: #dc2626;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 10px 15px;
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a5ca6;
        box-shadow: 0 0 0 3px rgba(26,92,166,0.1);
    }
</style>
@endsection

@section('content')

<!-- Header -->
<div class="mb-4">
    <a href="{{ route('cabang.index') }}" class="btn btn-light bg-white" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" title="Kembali">
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

    <form action="{{ route('cabang.update', $cabang->id_cabang) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row mb-2">
            <div class="col-md-5 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Nama Cabang <span class="required-star">*</span></label>
                <input type="text" name="nama_cabang" class="form-control form-control-sm" value="{{ old('nama_cabang', $cabang->nama_cabang) }}" required>
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Penanggung Jawab (Admin)</label>
                <select name="id_penanggung_jawab" class="form-select form-select-sm">
                    <option value="">-- Pilih Penanggung Jawab --</option>
                    @foreach($adminCabangs as $admin)
                        <option value="{{ $admin->id_user }}" {{ old('id_penanggung_jawab', $cabang->id_penanggung_jawab) == $admin->id_user ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Status <span class="required-star">*</span></label>
                <select name="status" class="form-select form-select-sm" required>
                    <option value="aktif" {{ old('status', $cabang->status) == 'aktif' ? 'selected' : '' }}>Aktif (Cabang Buka)</option>
                    <option value="nonaktif" {{ old('status', $cabang->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif (Cabang Tutup)</option>
                </select>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">No. Telepon / HP</label>
                <input type="text" name="no_hp" class="form-control form-control-sm" value="{{ old('no_hp', $cabang->no_hp) }}">
            </div>
            <div class="col-md-8 mb-2">
                <label class="form-label" style="font-size: 11px; margin-bottom: 4px;">Alamat Lengkap</label>
                <input type="text" name="alamat" class="form-control form-control-sm" value="{{ old('alamat', $cabang->alamat) }}">
            </div>
        </div>

        <hr class="my-3" style="border-color: #f3f4f6;">
        
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('cabang.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 6px; font-weight: 500;">Batal</a>
            <button type="submit" class="btn btn-primary btn-sm" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500;"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
