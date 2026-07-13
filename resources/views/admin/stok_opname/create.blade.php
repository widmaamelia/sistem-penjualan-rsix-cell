@extends('layouts.admin')

@section('title', 'Buat Stok Opname')

@section('styles')
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 25px;
    }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('stok_opname.index') }}" class="btn btn-outline-secondary me-3" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <h4 class="m-0 fw-bold">Buat Stok Opname Baru</h4>
</div>

<div class="form-container shadow-sm">
    <form action="{{ route('stok_opname.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="form-label fw-bold">Keterangan Umum (Opsional)</label>
            <textarea name="keterangan_umum" class="form-control" rows="2" placeholder="Catatan untuk opname kali ini..."></textarea>
        </div>

        <h5 class="fw-bold mb-3">Daftar Produk</h5>
        <div class="alert alert-info py-2" style="font-size: 13px;">
            <i class="fa-solid fa-circle-info me-1"></i> Isi kolom <strong>Stok Fisik</strong> hanya pada barang yang ingin disesuaikan. Kosongkan jika stok sudah sesuai.
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th style="font-size: 13px;">Kode / Nama Produk</th>
                        <th style="font-size: 13px; width: 120px;" class="text-center">Stok Sistem</th>
                        <th style="font-size: 13px; width: 150px;">Stok Fisik <span class="text-danger">*</span></th>
                        <th style="font-size: 13px; width: 120px;" class="text-center">Selisih</th>
                        <th style="font-size: 13px; width: 200px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $index => $produk)
                        @php
                            $stokSistem = $produk->stokCabangs->first() ? $produk->stokCabangs->first()->stok_sekarang : 0;
                        @endphp
                        <tr>
                            <td class="align-middle">
                                <span class="text-muted" style="font-size: 11px;">{{ $produk->kode_produk }}</span><br>
                                <span class="fw-bold">{{ $produk->nama_produk }}</span>
                                <input type="hidden" name="produks[{{ $index }}][id_produk]" value="{{ $produk->id_produk }}">
                                <input type="hidden" name="produks[{{ $index }}][stok_sistem]" value="{{ $stokSistem }}" id="sistem_{{ $index }}">
                            </td>
                            <td class="align-middle text-center fs-5 fw-bold text-secondary">
                                {{ $stokSistem }}
                            </td>
                            <td class="align-middle">
                                <input type="number" name="produks[{{ $index }}][stok_fisik]" id="fisik_{{ $index }}" class="form-control form-control-sm text-center input-fisik" data-index="{{ $index }}" placeholder="0" min="0">
                            </td>
                            <td class="align-middle text-center">
                                <span id="selisih_{{ $index }}" class="fw-bold">-</span>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="produks[{{ $index }}][keterangan]" class="form-control form-control-sm" placeholder="Catatan...">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; padding: 10px 24px; border-radius: 8px;">
                <i class="fa-solid fa-paper-plane me-1"></i> Submit untuk Persetujuan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.input-fisik').forEach(input => {
        input.addEventListener('input', function() {
            const index = this.getAttribute('data-index');
            const stokSistem = parseInt(document.getElementById('sistem_' + index).value) || 0;
            const stokFisik = this.value;
            
            const selisihSpan = document.getElementById('selisih_' + index);
            
            if (stokFisik === '') {
                selisihSpan.innerText = '-';
                selisihSpan.className = 'fw-bold';
            } else {
                const selisih = parseInt(stokFisik) - stokSistem;
                selisihSpan.innerText = (selisih > 0 ? '+' : '') + selisih;
                
                if (selisih > 0) {
                    selisihSpan.className = 'fw-bold text-success';
                } else if (selisih < 0) {
                    selisihSpan.className = 'fw-bold text-danger';
                } else {
                    selisihSpan.className = 'fw-bold text-secondary';
                }
            }
        });
    });
</script>
@endsection
