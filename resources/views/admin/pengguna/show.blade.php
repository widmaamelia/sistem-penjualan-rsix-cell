@extends('layouts.admin')

@section('title', 'Detail Profil Pengguna - ' . $pengguna->name)

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

    .profile-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 40px 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        gap: 40px;
    }

    .profile-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: 700;
        flex-shrink: 0;
        border: 4px solid #fff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .info-group {
        margin-bottom: 20px;
    }

    .info-label {
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 15px;
        font-weight: 500;
        color: #111827;
    }
    
    .badge-status {
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 13px;
        display: inline-block;
    }
    
    .badge-status-aktif { background-color: #dcfce7; color: #166534; }
    .badge-status-nonaktif { background-color: #f3f4f6; color: #4b5563; }
</style>
@endsection

@section('content')

<!-- Header Action -->
<div class="header-action">
    <h1 class="page-title">
        <a href="{{ route('pengguna.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
        Profil Karyawan
    </h1>
    <div>
        <a href="{{ route('pengguna.edit', $pengguna->id_user) }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 500; background-color: #1a5ca6; border-color: #1a5ca6;">
            <i class="fa-solid fa-pen-to-square me-2"></i>Edit Data
        </a>
    </div>
</div>

<div class="profile-card">
    @php
        $initials = collect(explode(' ', $pengguna->name))->map(function($segment) { return strtoupper(substr($segment, 0, 1)); })->take(2)->join('');
        if ($pengguna->role == 'super_admin') {
            $avatarBg = '#e0e7ff'; $avatarColor = '#4f46e5'; $roleName = 'Super Admin';
        } elseif ($pengguna->role == 'admin_cabang') {
            $avatarBg = '#fce7f3'; $avatarColor = '#be185d'; $roleName = 'Admin Cabang';
        } else {
            $avatarBg = '#ffedd5'; $avatarColor = '#c2410c'; $roleName = 'Karyawan';
        }
    @endphp

    <div class="text-center">
        <div class="profile-avatar-large mb-3 mx-auto" style="background-color: {{ $avatarBg }}; color: {{ $avatarColor }};">
            {{ $initials }}
        </div>
        
        @if($pengguna->status == 'aktif')
            <div class="badge-status badge-status-aktif">Akun Aktif</div>
        @else
            <div class="badge-status badge-status-nonaktif">Akun Nonaktif</div>
        @endif
    </div>

    <div style="flex: 1;">
        <h2 class="fw-bold text-dark mb-1">{{ $pengguna->name }}</h2>
        <p class="text-muted mb-4 fs-5"><i class="fa-solid fa-envelope me-2"></i> {{ $pengguna->email }}</p>
        
        <hr class="mb-4">

        <div class="row g-4">
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Posisi / Peran</div>
                    <div class="info-value">
                        <i class="fa-solid fa-user-shield text-muted me-2"></i> {{ $roleName }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Penempatan Cabang</div>
                    <div class="info-value">
                        <i class="fa-solid fa-store text-muted me-2"></i> {{ $pengguna->cabang ? $pengguna->cabang->nama_cabang : 'Kantor Pusat (Semua Cabang)' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Akun Didaftarkan Pada</div>
                    <div class="info-value">
                        <i class="fa-regular fa-calendar text-muted me-2"></i> {{ $pengguna->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-group">
                    <div class="info-label">Terakhir Diperbarui</div>
                    <div class="info-value">
                        <i class="fa-solid fa-clock-rotate-left text-muted me-2"></i> {{ $pengguna->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
