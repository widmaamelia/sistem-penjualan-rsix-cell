@extends('layouts.admin')

@section('title', 'Cabang')

@section('styles')
<style>
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 15px;
    }

    .search-input {
        width: 350px;
        position: relative;
    }

    .search-input i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .search-input input {
        padding: 6px 12px 6px 36px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        font-size: 13.5px;
    }

    .btn-primary-custom {
        background-color: #1a5ca6;
        border-color: #1a5ca6;
        color: white;
        font-weight: 500;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 13.5px;
    }

    .btn-primary-custom:hover {
        background-color: #154a85;
        color: white;
    }

    /* Table Styling */
    .table-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .table th {
        font-size: 11px;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 700;
        letter-spacing: 0.5px;
        background-color: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 16px;
        vertical-align: middle;
    }

    .table td {
        font-size: 13px;
        color: #374151;
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f3f4f6;
    }

    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
    }
    
    .badge-status-aktif { background-color: #dcfce7; color: #166534; }
    .badge-status-nonaktif { background-color: #fee2e2; color: #991b1b; }

    /* Actions */
    .action-icons {
        display: flex;
        gap: 12px;
    }
    
    .action-icons a, .action-icons button {
        background: none;
        border: none;
        padding: 0;
        color: #6b7280;
        font-size: 14px;
        transition: color 0.2s;
        cursor: pointer;
        text-decoration: none;
    }
    
    .action-icons a:hover {
        color: #1a5ca6;
    }
    
    .action-icons .text-primary:hover {
        color: #1a5ca6 !important;
    }
    
    .action-icons .text-danger:hover {
        color: #dc2626 !important;
    }
</style>
@endsection

@section('content')

<!-- Notifikasi -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 14px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 14px;">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Action Bar -->
<div class="action-bar">
    <form action="{{ route('cabang.index') }}" method="GET" class="search-input m-0" id="searchForm">
        <i class="fa-solid fa-magnifying-glass" style="z-index: 10;"></i>
        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari cabang..." value="{{ request('search') }}">
    </form>
    <div>
        <a href="{{ route('cabang.create') }}" class="btn btn-primary-custom text-decoration-none">
            <i class="fa-solid fa-plus me-1"></i> Tambah Cabang
        </a>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="padding-left: 20px;">Nama Cabang</th>
                <th>Alamat</th>
                <th>Penanggung Jawab</th>
                <th>No. Telepon</th>
                <th>Status</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cabangs as $cabang)
                <tr>
                    <td style="padding-left: 20px;" class="fw-bold text-primary">{{ $cabang->nama_cabang }}</td>
                    <td class="text-muted">{{ Str::limit($cabang->alamat, 40) ?? '-' }}</td>
                    <td class="text-dark fw-medium">
                        {{ $cabang->penanggungJawab->name ?? '-' }}
                    </td>
                    <td class="text-muted">{{ $cabang->no_hp ?? '-' }}</td>
                    <td>
                        <div class="form-check form-switch" style="padding-left: 2.5em;">
                            <input class="form-check-input toggle-status" type="checkbox" role="switch" data-id="{{ $cabang->id_cabang }}" data-type="cabang" {{ strtolower($cabang->status) == 'aktif' ? 'checked' : '' }} style="cursor: pointer; width: 40px; height: 20px;">
                        </div>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="#" title="Lihat" class="btn-show-cabang" data-id="{{ $cabang->id_cabang }}"><i class="fa-regular fa-eye"></i></a>
                            <a href="{{ route('cabang.edit', $cabang->id_cabang) }}" class="text-primary" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button type="button" class="text-danger btn-delete-cabang" title="Hapus"
                                data-id="{{ $cabang->id_cabang }}"
                                data-nama="{{ $cabang->nama_cabang }}">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data cabang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
        @if(isset($cabangs) && $cabangs->count() > 0)
            <div>Menampilkan <strong>{{ $cabangs->firstItem() }}-{{ $cabangs->lastItem() }}</strong> dari <strong>{{ $cabangs->total() }}</strong> cabang</div>
            <div>
                {{ $cabangs->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div>Menampilkan 0 data</div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fa-solid fa-triangle-exclamation text-danger" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Cabang?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin menghapus cabang <strong id="deleteNamaCabang"></strong>?</p>
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

<!-- Modal Detail Cabang (AJAX Placeholder) -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Detail Cabang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="text-muted" style="font-size: 12px; text-transform: uppercase; font-weight: 600;">Nama Cabang</label>
                    <div id="detailNama" class="fw-bold text-dark fs-5">Memuat...</div>
                </div>
                <div class="mb-3">
                    <label class="text-muted" style="font-size: 12px; text-transform: uppercase; font-weight: 600;">Alamat Lengkap</label>
                    <div id="detailAlamat" class="fw-medium text-dark">...</div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <label class="text-muted" style="font-size: 12px; text-transform: uppercase; font-weight: 600;">Penanggung Jawab</label>
                        <div id="detailPj" class="fw-medium text-dark">...</div>
                    </div>
                    <div class="col-6">
                        <label class="text-muted" style="font-size: 12px; text-transform: uppercase; font-weight: 600;">No. Telepon</label>
                        <div id="detailTelepon" class="fw-medium text-dark">...</div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <div id="detailStatus" class="badge-status d-inline-block">Aktif</div>
                </div>
            </div>
            <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
                <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function attachListeners() {
        // Hapus Modal
        document.querySelectorAll('.btn-delete-cabang').forEach(btn => {
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                document.getElementById('deleteNamaCabang').innerText = nama;
                document.getElementById('formDelete').action = "{{ url('/cabang') }}/" + id;
                new bootstrap.Modal(document.getElementById('modalHapus')).show();
            });
        });

        // Detail Modal
        document.querySelectorAll('.btn-show-cabang').forEach(btn => {
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                
                document.getElementById('detailNama').innerText = "Memuat...";
                document.getElementById('detailAlamat').innerText = "...";
                
                const modalDetail = new bootstrap.Modal(document.getElementById('modalDetail'));
                modalDetail.show();

                fetch("{{ url('/cabang') }}/" + id, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailNama').innerText = data.nama_cabang;
                    document.getElementById('detailAlamat').innerText = data.alamat || '-';
                    document.getElementById('detailPj').innerText = data.penanggung_jawab ? data.penanggung_jawab.name : '-';
                    document.getElementById('detailTelepon').innerText = data.no_hp || '-';
                    
                    const statusEl = document.getElementById('detailStatus');
                    if(data.status && data.status.toLowerCase() == 'aktif') {
                        statusEl.className = "badge-status badge-status-aktif d-inline-block px-3 py-2";
                        statusEl.innerText = "Status: Aktif";
                    } else {
                        statusEl.className = "badge-status badge-status-nonaktif d-inline-block px-3 py-2";
                        statusEl.innerText = "Status: Non-aktif";
                    }
                })
                .catch(err => {
                    document.getElementById('detailNama').innerText = "Gagal memuat data";
                });
            });
        });

        // Toggle Status
        document.querySelectorAll('.toggle-status').forEach(toggle => {
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);
            newToggle.addEventListener('change', function() {
                const id = this.getAttribute('data-id');
                const type = this.getAttribute('data-type');
                const isChecked = this.checked;
                
                fetch(`/${type}/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(!data.success) {
                        this.checked = !isChecked; // Revert if failed
                        alert(data.message || 'Terjadi kesalahan.');
                    }
                })
                .catch(error => {
                    this.checked = !isChecked; // Revert if error
                    console.error('Error:', error);
                    alert('Gagal mengubah status.');
                });
            });
        });
    }

    attachListeners();

    // Live Search (Debounce)
    let searchTimer;
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');

    if (searchInput && searchForm) {
        let val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                searchForm.submit();
            }, 600);
        });
    }
</script>
@endsection
