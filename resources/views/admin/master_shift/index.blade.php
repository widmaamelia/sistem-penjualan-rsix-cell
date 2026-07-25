@extends('layouts.admin')

@section('title', 'Master Shift')

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
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" style="background-color: #1a5ca6;">
        <i class="fa-solid fa-plus me-1"></i> Tambah Master Shift
    </button>
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
                            <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $shift->id_master_shift }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('master_shift.destroy', $shift->id_master_shift) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus master shift ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit{{ $shift->id_master_shift }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                                <form action="{{ route('master_shift.update', $shift->id_master_shift) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                        <h5 class="fw-bold mb-0">Edit Master Shift</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-medium text-muted" style="font-size: 13px;">Nama Shift</label>
                                            <input type="text" name="nama_shift" class="form-control" value="{{ $shift->nama_shift }}" required>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="form-label fw-medium text-muted" style="font-size: 13px;">Jam Mulai</label>
                                                <input type="time" name="jam_mulai" class="form-control" value="{{ $shift->jam_mulai }}" required>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-medium text-muted" style="font-size: 13px;">Jam Selesai</label>
                                                <input type="time" name="jam_selesai" class="form-control" value="{{ $shift->jam_selesai }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6;">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada data master shift.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <form action="{{ route('master_shift.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Tambah Master Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Nama Shift (Contoh: Shift Pagi)</label>
                        <input type="text" name="nama_shift" class="form-control" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-medium text-muted" style="font-size: 13px;">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium text-muted" style="font-size: 13px;">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6;">Simpan Shift</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
