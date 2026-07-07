@extends('layouts.admin')

@section('title', 'Tambah Cabang Baru')

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

    .form-control {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 10px 15px;
        font-size: 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
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
        Tambah Cabang
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

    <form action="{{ route('cabang.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="form-label">Nama Cabang <span class="required-star">*</span></label>
            <input type="text" name="nama_cabang" class="form-control" placeholder="Contoh: Cabang Utama Talang Babungo" value="{{ old('nama_cabang') }}" required>
        </div>

        <div class="mb-4">
            <label class="form-label">No. Telepon / HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 0812-3456-7890" value="{{ old('no_hp') }}">
            <small class="text-muted mt-1 d-block" style="font-size: 12px;">Bisa dikosongkan jika belum ada nomor.</small>
        </div>

        <div class="mb-4">
            <label class="form-label">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh: Jl. Raya Lintas Sumatera No. 12, Solok">{{ old('alamat') }}</textarea>
        </div>

        <hr class="my-4">
        
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('cabang.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 500; min-width: 100px;">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 8px; font-weight: 500; min-width: 120px;">Simpan Cabang</button>
        </div>
    </form>
</div>

@endsection
