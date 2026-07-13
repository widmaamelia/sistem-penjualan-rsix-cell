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

<!-- Header Action -->
<div class="header-action">
    <h1 class="page-title">
        <a href="{{ route('cabang.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        Edit Cabang
    </h1>
</div>

<div class="form-container">
    @if ($errors->any())
        <div class="alert alert-danger" style="font-size: 14px; border-radius: 8px;">
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
        
        <div class="mb-4">
            <label class="form-label">Nama Cabang <span class="required-star">*</span></label>
            <input type="text" name="nama_cabang" class="form-control" value="{{ old('nama_cabang', $cabang->nama_cabang) }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label">No. Telepon / HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $cabang->no_hp) }}">
        </div>

        <div class="mb-4">
            <label class="form-label">Penanggung Jawab Cabang (Admin Cabang)</label>
            <select name="id_penanggung_jawab" class="form-control">
                <option value="">-- Pilih Penanggung Jawab --</option>
                @foreach($adminCabangs as $admin)
                    <option value="{{ $admin->id_user }}" {{ old('id_penanggung_jawab', $cabang->id_penanggung_jawab) == $admin->id_user ? 'selected' : '' }}>
                        {{ $admin->name }} ({{ $admin->email }})
                    </option>
                @endforeach
            </select>
            <small class="text-muted mt-1 d-block" style="font-size: 12px;">Diambil dari pengguna dengan role Admin Cabang.</small>
        </div>

        <div class="mb-4">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $cabang->alamat) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label">Status <span class="required-star">*</span></label>
            <select name="status" class="form-select" required>
                <option value="aktif" {{ old('status', $cabang->status) == 'aktif' ? 'selected' : '' }}>Aktif (Cabang Buka)</option>
                <option value="nonaktif" {{ old('status', $cabang->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif (Cabang Tutup)</option>
            </select>
            <small class="text-muted mt-1 d-block" style="font-size: 12px;">Cabang Non-aktif tidak akan bisa melakukan transaksi.</small>
        </div>

        <hr class="my-4">
        
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('cabang.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 500; min-width: 100px;">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 8px; font-weight: 500; min-width: 120px;">Simpan Perubahan</button>
        </div>
    </form>
</div>

@endsection
