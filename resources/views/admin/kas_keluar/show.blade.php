@extends('layouts.admin')

@section('title', 'Detail Kas Keluar')

@section('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 20px;
        max-width: 700px;
        margin: 0 auto;
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
</style>
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('kas_keluar.index') }}" class="btn btn-light bg-white" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>

<div class="profile-card mt-3">
    <div class="row g-3">
        <div class="col-md-6">
            <div class="info-group">
                <div class="info-label">Tanggal & Waktu</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($kasKeluar->tanggal)->format('d F Y, H:i') }} WIB
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-group">
                <div class="info-label">Cabang</div>
                <div class="info-value">
                    {{ $kasKeluar->cabang->nama_cabang ?? ($kasKeluar->shift->cabang->nama_cabang ?? 'Cabang Dihapus') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-group">
                <div class="info-label">Jumlah Pengeluaran</div>
                <div class="info-value text-danger fw-bold">
                    Rp {{ number_format($kasKeluar->jumlah_pengeluaran, 0, ',', '.') }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-group">
                <div class="info-label">Dicatat Oleh</div>
                <div class="info-value">
                    {{ $kasKeluar->shift->user->name ?? 'Otomatis Sistem' }}
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-2">
            @php
                $parts = explode(':', $kasKeluar->keterangan);
                $mainKeterangan = trim($parts[0]);
                $detailItems = isset($parts[1]) ? trim($parts[1]) : '';
            @endphp
            <div class="info-group mb-0">
                <div class="info-label">Keterangan / Keperluan</div>
                <div class="info-value mt-1" style="line-height: 1.6; font-size: 13.5px;">
                    {{ $mainKeterangan }}
                    
                    @if($detailItems)
                        <div class="mt-1">
                            <ul class="mb-0 ps-3" style="list-style-type: disc;">
                                @foreach(explode(', ', $detailItems) as $item)
                                    @if(trim($item))
                                        <li>{{ trim($item) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
