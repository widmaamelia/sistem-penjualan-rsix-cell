@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru')

@section('styles')
<style>
    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a5ca6;
        margin: 0 0 5px 0;
    }
    
    .page-desc {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 25px;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #4b5563;
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
    }
    
    .form-control:focus {
        border-color: #1a5ca6;
        box-shadow: 0 0 0 3px rgba(26,92,166,0.1);
    }
    
    .form-text {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }
</style>
@endsection

@section('content')

<!-- Global Error Display -->
@if ($errors->any())
    <div class="alert alert-danger" style="font-size: 14px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Header -->
<div class="mb-4">
    <div class="text-muted" style="font-size: 13px; margin-bottom: 10px;">
        <a href="{{ route('produk.index') }}" class="text-decoration-none text-muted">Produk</a> &rsaquo; 
        <a href="{{ route('kategori.index') }}" class="text-decoration-none text-muted">Kelola Kategori</a> &rsaquo; 
        <strong class="text-primary" style="color: #1a5ca6 !important;">Tambah Kategori</strong>
    </div>
    <h1 class="page-title">Tambah Kategori Baru</h1>
    <p class="page-desc">Gunakan form di bawah ini untuk menambahkan kategori produk baru ke dalam sistem inventaris Rsix Cell.</p>
</div>

<!-- Form Container -->
<div class="form-card">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="form-label">Nama Kategori <span class="required-star">*</span></label>
            <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Aksesoris Smartphone" value="{{ old('nama_kategori') }}" required>
            <div class="form-text">Pastikan nama kategori unik dan deskriptif.</div>
        </div>
        
        <hr class="my-4" style="border-color: #e5e7eb;">
        
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 500;">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 8px; font-weight: 500;">
                <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Kategori
            </button>
        </div>
    </form>
</div>

@endsection
