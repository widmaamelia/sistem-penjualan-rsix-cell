@extends('layouts.admin')

@section('title', 'Jadwal Shift Kerja')

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



@if(auth()->user()->role === 'super')
<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="{{ route('jadwal_shift.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 13px;">Filter Cabang</label>
                <select name="id_cabang" class="form-select" style="border-radius: 6px; border: 1px solid #d1d5db; padding: 6px 12px; font-size: 13.5px;">
                    <option value="">Semua Cabang</option>
                    @foreach(\App\Models\Cabang::all() as $cabang)
                        <option value="{{ $cabang->id_cabang }}" {{ request('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Terapkan Filter</button>
                @if(request()->has('id_cabang') && request('id_cabang') != '')
                    <a href="{{ route('jadwal_shift.index') }}" class="btn btn-outline-secondary" style="border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>
@endif

<div class="card shadow-sm border-0 rounded-3">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 60px;">NO</th>

                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">KARYAWAN</th>
                    @if(auth()->user()->role === 'super')
                        <th class="py-3 px-4 text-muted" style="font-size: 12px;">CABANG</th>
                    @endif
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">SHIFT</th>

                    @if(auth()->user()->role === 'admin cabang')
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 100px;">AKSI</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if(auth()->user()->role === 'admin cabang')
                    @forelse($karyawanSchedules as $index => $item)
                        <tr>
                            <td class="px-4 text-muted">{{ $index + 1 }}</td>

                            <td class="px-4">
                                <span class="fw-bold text-dark">{{ $item->karyawan->name }}</span><br>
                                <small class="text-muted">{{ $item->karyawan->email }}</small>
                            </td>
                            <td class="px-4">
                                @if($item->jadwal)
                                    <span class="fw-bold text-primary">{{ $item->jadwal->masterShift->nama_shift ?? 'Shift Dihapus' }}</span>

                                    @if($item->jadwal->keterangan)
                                        <div class="text-muted mt-1" style="font-size: 11px;"><i class="fa-regular fa-comment-dots me-1"></i> {{ $item->jadwal->keterangan }}</div>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="px-4">
                                @if($item->jadwal)
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary" title="Edit Jadwal" onclick="tugaskanKaryawan({{ $item->karyawan->id_user }})" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-jadwal" 
                                            title="Batalkan Jadwal"
                                            data-id="{{ $item->jadwal->id_jadwal_shift }}"
                                            data-nama="{{ $item->karyawan->name }}">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                @else
                                    <button class="btn btn-sm btn-primary" style="background-color: #1a5ca6; font-size: 11px; border-radius: 6px; font-weight: 500;" onclick="tugaskanKaryawan({{ $item->karyawan->id_user }})" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                        <i class="fa-solid fa-calendar-plus me-1"></i> Jadwalkan
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data karyawan di cabang ini.</td>
                        </tr>
                    @endforelse
                @else
                    @forelse($jadwalShifts as $index => $jadwal)
                        <tr>
                            <td class="px-4 text-muted">{{ $jadwalShifts->firstItem() + $index }}</td>

                            <td class="px-4">
                                <span class="fw-bold text-dark">{{ $jadwal->user->name ?? 'User Dihapus' }}</span>
                            </td>
                            @if(auth()->user()->role === 'super')
                                <td class="px-4 text-primary">{{ $jadwal->cabang->nama_cabang }}</td>
                            @endif
                            <td class="px-4">
                                <span class="fw-bold text-primary">{{ $jadwal->masterShift->nama_shift ?? 'Shift Dihapus' }}</span>

                                </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'super' ? '7' : '6' }}" class="text-center py-4 text-muted">Belum ada jadwal shift.</td>
                        </tr>
                    @endforelse
                @endif
            </tbody>
        </table>
    </div>
    @if(auth()->user()->role === 'super' && $jadwalShifts->hasPages())
        <div class="card-footer bg-white border-top py-3 px-4">
            {{ $jadwalShifts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@if(auth()->user()->role === 'admin cabang')
<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <form action="{{ route('jadwal_shift.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Tugaskan Jadwal Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="tanggal" id="inputTanggalMulai" value="{{ $tanggal }}">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Karyawan</label>
                        <select name="id_user" id="selectKaryawan" class="form-select" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $k)
                                <option value="{{ $k->id_user }}">{{ $k->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Pilih Master Shift</label>
                        <select name="id_master_shift" class="form-select" required>
                            <option value="">-- Pilih Jam Kerja --</option>
                            @foreach($masterShifts as $ms)
                                <option value="{{ $ms->id_master_shift }}">{{ $ms->nama_shift }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6;">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Modal Hapus Jadwal -->
<div class="modal fade" id="modalHapusJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fa-solid fa-triangle-exclamation text-danger" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Jadwal Shift?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin membatalkan jadwal shift untuk <strong id="deleteNamaKaryawan"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                <form id="formDeleteJadwal" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="border-radius: 8px; font-weight: 500;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endif

<!-- Print Styles -->
<style type="text/css" media="print">
    body * {
        visibility: hidden;
    }
    .table-responsive, .table-responsive * {
        visibility: visible;
    }
    .table-responsive {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .badge, .btn, form {
        display: none !important;
    }
</style>

@section('scripts')
<script>
    function tugaskanKaryawan(idUser) {
        document.getElementById('selectKaryawan').value = idUser;
        document.getElementById('inputTanggalMulai').value = "{{ $tanggal }}";
    }

    document.querySelectorAll('.btn-delete-jadwal').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            
            document.getElementById('deleteNamaKaryawan').innerText = nama;
            
            const formDelete = document.getElementById('formDeleteJadwal');
            formDelete.action = "{{ url('/jadwal_shift') }}/" + id;
            
            const modalHapus = new bootstrap.Modal(document.getElementById('modalHapusJadwal'));
            modalHapus.show();
        });
    });

</script>
@endsection

@endsection
