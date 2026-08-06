@extends('layouts.admin')

@section('title', 'Master Shift')

@section('styles')
<style>
    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
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

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-end align-items-center mb-3">
    <a href="{{ route('master_shift.create') }}" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Master Shift
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 60px;">NO</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">NAMA SHIFT</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">JAM MULAI</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">JAM SELESAI</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 150px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masterShifts as $index => $shift)
                    <tr>
                        <td class="px-4 text-muted">{{ $index + 1 }}</td>
                        <td class="px-4 fw-bold text-dark">{{ $shift->nama_shift }}</td>
                        <td class="px-4"><span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1">{{ substr($shift->jam_mulai, 0, 5) }}</span></td>
                        <td class="px-4"><span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">{{ substr($shift->jam_selesai, 0, 5) }}</span></td>
                        <td class="px-4">
                            <a href="{{ route('master_shift.edit', $shift->id_master_shift) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-shift" 
                                data-id="{{ $shift->id_master_shift }}" 
                                data-nama="{{ $shift->nama_shift }}"
                                title="Hapus">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>


                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data master shift.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fa-solid fa-triangle-exclamation text-danger" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Master Shift?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin menghapus master shift <strong id="deleteNamaShift"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                <form id="formDelete" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="border-radius: 8px; font-weight: 500;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.btn-delete-shift').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            
            document.getElementById('deleteNamaShift').innerText = nama;
            
            const formDelete = document.getElementById('formDelete');
            formDelete.action = "{{ url('/master_shift') }}/" + id;
            
            const modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));
            modalHapus.show();
        });
    });
</script>
@endsection
