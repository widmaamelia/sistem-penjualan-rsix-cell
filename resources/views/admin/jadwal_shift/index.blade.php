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

<div class="d-flex justify-content-end align-items-center mb-3">
    @if(auth()->user()->role === 'admin cabang')
        <div>
            <button class="btn btn-outline-secondary me-2" onclick="window.print()">
                <i class="fa-solid fa-print me-1"></i> Cetak Jadwal
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah" onclick="tugaskanKaryawan('', 'biasa')" style="background-color: #1a5ca6;">
                <i class="fa-solid fa-calendar-plus me-1"></i> Tugaskan Shift
            </button>
        </div>
    @endif
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="{{ route('jadwal_shift.index') }}" method="GET" class="row g-3">
            @if(auth()->user()->role === 'super')
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 13px;">Filter Cabang</label>
                <select name="id_cabang" class="form-select">
                    <option value="">Semua Cabang</option>
                    @foreach(\App\Models\Cabang::all() as $cabang)
                        <option value="{{ $cabang->id_cabang }}" {{ request('id_cabang') == $cabang->id_cabang ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 13px;">Filter Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', $tanggal ?? '') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100" style="background-color: #1a5ca6;">Terapkan Filter</button>
                @if(request()->has('tanggal') || request()->has('id_cabang'))
                    <a href="{{ route('jadwal_shift.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 60px;">NO</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">TANGGAL</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">KARYAWAN</th>
                    @if(auth()->user()->role === 'super')
                        <th class="py-3 px-4 text-muted" style="font-size: 12px;">CABANG</th>
                    @endif
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">SHIFT</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">STATUS</th>
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
                            <td class="px-4 fw-bold">{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</td>
                            <td class="px-4">
                                <span class="fw-bold text-dark">{{ $item->karyawan->name }}</span><br>
                                <small class="text-muted">{{ $item->karyawan->email }}</small>
                            </td>
                            <td class="px-4">
                                @if($item->jadwal)
                                    <span class="fw-bold text-primary">{{ $item->jadwal->masterShift->nama_shift ?? 'Shift Dihapus' }}</span>
                                    @if($item->jadwal->tipe === 'lembur')
                                        <span class="badge bg-warning text-dark ms-1" style="font-size: 10px;">Lembur</span>
                                    @elseif($item->jadwal->tipe === 'izin')
                                        <span class="badge bg-danger text-white ms-1" style="font-size: 10px;">Izin</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ substr($item->jadwal->masterShift->jam_mulai ?? '', 0, 5) }} - {{ substr($item->jadwal->masterShift->jam_selesai ?? '', 0, 5) }}</small>
                                    @if($item->jadwal->keterangan)
                                        <div class="text-muted mt-1" style="font-size: 11px;"><i class="fa-regular fa-comment-dots me-1"></i> {{ $item->jadwal->keterangan }}</div>
                                    @endif
                                @else
                                    <span class="text-muted" style="font-style: italic;">Libur / Belum Terjadwal</span>
                                @endif
                            </td>
                            <td class="px-4">
                                @if($item->jadwal)
                                    @if($item->jadwal->status === 'terjadwal')
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">Terjadwal</span>
                                    @elseif($item->jadwal->status === 'berjalan')
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">Sedang Berjalan</span>
                                    @elseif($item->jadwal->status === 'dibatalkan')
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Selesai</span>
                                    @endif
                                @else
                                    <span class="badge bg-light text-dark px-3 py-2 border">Libur</span>
                                @endif
                            </td>
                            <td class="px-4">
                                @if($item->jadwal)
                                    @if($item->jadwal->status === 'terjadwal' && $item->jadwal->tipe !== 'izin')
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-outline-warning" title="Tandai Izin" onclick="openModalIzin({{ $item->jadwal->id_jadwal_shift }}, '{{ $item->karyawan->name }}')">
                                                <i class="fa-solid fa-user-slash"></i>
                                            </button>
                                            <form action="{{ route('jadwal_shift.destroy', $item->jadwal->id_jadwal_shift) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus jadwal shift ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Batalkan Jadwal">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($item->jadwal->status === 'dibatalkan' || $item->jadwal->tipe === 'izin')
                                        <form action="{{ route('jadwal_shift.destroy', $item->jadwal->id_jadwal_shift) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data izin/riwayat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Riwayat">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted" style="font-size: 11px;">Terkunci</span>
                                    @endif
                                @else
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-primary" style="background-color: #1a5ca6; font-size: 11px; border-radius: 6px; font-weight: 500;" onclick="tugaskanKaryawan({{ $item->karyawan->id_user }}, 'biasa')" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="fa-solid fa-calendar-plus me-1"></i> Jadwalkan
                                        </button>
                                        <button class="btn btn-sm btn-warning text-dark" style="font-size: 11px; border-radius: 6px; font-weight: 500;" onclick="tugaskanKaryawan({{ $item->karyawan->id_user }}, 'lembur')" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="fa-solid fa-user-clock me-1"></i> Lembur
                                        </button>
                                    </div>
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
                            <td class="px-4 fw-bold">{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                            <td class="px-4">
                                <span class="fw-bold text-dark">{{ $jadwal->user->name ?? 'User Dihapus' }}</span>
                            </td>
                            @if(auth()->user()->role === 'super')
                                <td class="px-4 text-primary">{{ $jadwal->cabang->nama_cabang }}</td>
                            @endif
                            <td class="px-4">
                                <span class="fw-bold text-primary">{{ $jadwal->masterShift->nama_shift ?? 'Shift Dihapus' }}</span>
                                @if($jadwal->tipe === 'lembur')
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 10px;">Lembur</span>
                                @elseif($jadwal->tipe === 'izin')
                                    <span class="badge bg-danger text-white ms-1" style="font-size: 10px;">Izin</span>
                                @endif
                                <br>
                                <small class="text-muted">{{ substr($jadwal->masterShift->jam_mulai ?? '', 0, 5) }} - {{ substr($jadwal->masterShift->jam_selesai ?? '', 0, 5) }}</small>
                            </td>
                            <td class="px-4">
                                @if($jadwal->status === 'terjadwal')
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">Terjadwal</span>
                                @elseif($jadwal->status === 'berjalan')
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">Sedang Berjalan</span>
                                @elseif($jadwal->status === 'dibatalkan')
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">Dibatalkan</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Selesai</span>
                                @endif
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
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-medium text-muted" style="font-size: 13px;">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="inputTanggalMulai" class="form-control" required value="{{ $tanggal }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium text-muted" style="font-size: 13px;">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="inputTanggalSelesai" class="form-control" required value="{{ $tanggal }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted mb-2 d-block" style="font-size: 13px;">Pilih Hari Kerja</label>
                        <div class="d-flex flex-wrap gap-2">
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input check-hari" type="checkbox" name="hari[]" id="hari_1" value="1" checked>
                                <label class="form-check-label" style="font-size: 12px;" for="hari_1">Sen</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input check-hari" type="checkbox" name="hari[]" id="hari_2" value="2" checked>
                                <label class="form-check-label" style="font-size: 12px;" for="hari_2">Sel</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input check-hari" type="checkbox" name="hari[]" id="hari_3" value="3" checked>
                                <label class="form-check-label" style="font-size: 12px;" for="hari_3">Rab</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input check-hari" type="checkbox" name="hari[]" id="hari_4" value="4" checked>
                                <label class="form-check-label" style="font-size: 12px;" for="hari_4">Kam</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input check-hari" type="checkbox" name="hari[]" id="hari_5" value="5" checked>
                                <label class="form-check-label" style="font-size: 12px;" for="hari_5">Jum</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input check-hari" type="checkbox" name="hari[]" id="hari_6" value="6" checked>
                                <label class="form-check-label" style="font-size: 12px;" for="hari_6">Sab</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input class="form-check-input check-hari" type="checkbox" name="hari[]" id="hari_7" value="7">
                                <label class="form-check-label" style="font-size: 12px;" for="hari_7">Min</label>
                            </div>
                        </div>
                    </div>
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
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Tipe Jadwal</label>
                        <select name="tipe" id="selectTipe" class="form-select" required>
                            <option value="biasa">Biasa (Reguler)</option>
                            <option value="lembur">Lembur (Overtime)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Keterangan / Catatan</label>
                        <input type="text" name="keterangan" id="inputKeterangan" class="form-control" placeholder="Contoh: Menggantikan Amelia yang Sakit">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Pilih Master Shift</label>
                        <select name="id_master_shift" class="form-select" required>
                            <option value="">-- Pilih Jam Kerja --</option>
                            @foreach($masterShifts as $ms)
                                <option value="{{ $ms->id_master_shift }}">{{ $ms->nama_shift }} ({{ substr($ms->jam_mulai, 0, 5) }} - {{ substr($ms->jam_selesai, 0, 5) }})</option>
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

<!-- Modal Izin -->
<div class="modal fade" id="modalIzin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <form id="formIzin" method="POST">
                @csrf
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Tandai Karyawan Izin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-3">Tandai bahwa <span id="namaKaryawanIzin" class="fw-bold text-dark"></span> izin tidak masuk kerja pada tanggal shift ini.</p>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Alasan / Keterangan Izin</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Izin Sakit (Ada Surat Dokter)" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan Izin</button>
                </div>
            </form>
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
    function tugaskanKaryawan(idUser, tipe = 'biasa') {
        document.getElementById('selectKaryawan').value = idUser;
        document.getElementById('selectTipe').value = tipe;
        document.getElementById('inputTanggalMulai').value = "{{ $tanggal }}";
        document.getElementById('inputTanggalSelesai').value = "{{ $tanggal }}";
        document.getElementById('inputKeterangan').value = "";
        
        // Reset check-hari checkboxes (default check Mon-Sat, uncheck Sun)
        const checkHaris = document.querySelectorAll('.check-hari');
        checkHaris.forEach(el => {
            if (el.value === '7') {
                el.checked = false;
            } else {
                el.checked = true;
            }
        });
    }

    function openModalIzin(idJadwal, namaKaryawan) {
        document.getElementById('namaKaryawanIzin').innerText = namaKaryawan;
        document.getElementById('formIzin').action = `/jadwal_shift/${idJadwal}/izin`;
        
        // Show modal manually
        var myModal = new bootstrap.Modal(document.getElementById('modalIzin'));
        myModal.show();
    }
</script>
@endsection
@endsection
