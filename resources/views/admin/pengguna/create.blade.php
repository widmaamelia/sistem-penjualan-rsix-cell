@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

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
        <a href="{{ route('pengguna.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        Tambah Pengguna
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

    <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf
        
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">Nama Lengkap <span class="required-star">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Alamat Email <span class="required-star">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: budi@rsixcell.com" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Password Sementara <span class="required-star">*</span></label>
            <input type="text" name="password" class="form-control" placeholder="Minimal 6 karakter" required minlength="6">
            <small class="text-muted mt-1 d-block" style="font-size: 12px;">Password ini digunakan oleh pengguna untuk login pertama kali.</small>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label">Peran (Role) <span class="required-star">*</span></label>
                <select name="role" id="roleSelect" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Peran --</option>
                    <option value="super" {{ old('role') == 'super' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin cabang" {{ old('role') == 'admin cabang' ? 'selected' : '' }}>Admin Cabang</option>
                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan (Kasir)</option>
                </select>
            </div>
            <div class="col-md-6" id="cabangContainer">
                <label class="form-label">Penempatan Cabang <span class="required-star">*</span></label>
                <select name="id_cabang" id="cabangSelect" class="form-select">
                    <option value="" disabled selected>-- Pilih Cabang --</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id_cabang }}" {{ old('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
                <small class="text-muted mt-1 d-block" id="cabangHint" style="font-size: 12px;">Pilih cabang tempat penugasan.</small>
            </div>
        </div>

        <hr class="my-4">
        
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 500; min-width: 100px;">Batal</a>
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 8px; font-weight: 500; min-width: 120px;">Simpan Pengguna</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('roleSelect');
        const cabangContainer = document.getElementById('cabangContainer');
        const cabangSelect = document.getElementById('cabangSelect');
        const cabangHint = document.getElementById('cabangHint');

        function toggleCabang() {
            if (roleSelect.value === 'super') {
                cabangSelect.disabled = true;
                cabangSelect.value = "";
                cabangSelect.removeAttribute('required');
                cabangHint.innerText = "Super Admin otomatis ditempatkan di Pusat / bebas cabang.";
            } else {
                cabangSelect.disabled = false;
                cabangSelect.setAttribute('required', 'required');
                cabangHint.innerText = "Pilih cabang fisik penempatan.";
            }
        }

        roleSelect.addEventListener('change', toggleCabang);
        
        // Panggil sekali saat load (berguna untuk old value validation error)
        if (roleSelect.value) {
            toggleCabang();
        }
    });
</script>
@endsection
