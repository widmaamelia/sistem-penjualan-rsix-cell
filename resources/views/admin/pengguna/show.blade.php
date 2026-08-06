@extends('layouts.admin')

@section('title', 'Detail Profil Pengguna - ' . $pengguna->name)

@section('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        display: flex;
        gap: 20px;
    }

    .profile-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        flex-shrink: 0;
        border: 3px solid #fff;
        box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    }

    .info-group {
        margin-bottom: 12px;
    }

    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 3px;
    }

    .info-value {
        font-size: 13px;
        font-weight: 500;
        color: #111827;
    }
    
    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
        display: inline-block;
    }
    
    .badge-status-aktif { background-color: #dcfce7; color: #166534; }
    .badge-status-nonaktif { background-color: #f3f4f6; color: #4b5563; }
</style>
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('pengguna.index') }}" class="btn btn-light bg-white" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    
    <a href="{{ route('pengguna.edit', $pengguna->id_user) }}" class="btn btn-primary btn-sm" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500;">
        <i class="fa-solid fa-pen-to-square me-1"></i> Edit Data
    </a>
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
        <h2 class="fw-bold text-dark mb-1" style="font-size: 18px;">{{ $pengguna->name }}</h2>
        <p class="text-muted mb-3" style="font-size: 13px;"><i class="fa-solid fa-envelope me-1"></i> {{ $pengguna->email }}</p>
        
        <hr class="mb-3">

        <div class="row g-3">
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
