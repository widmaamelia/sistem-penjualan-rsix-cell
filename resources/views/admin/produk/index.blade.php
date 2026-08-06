@extends('layouts.admin')

@section('title', 'Produk')

@section('styles')
<style>
    /* Styling khusus untuk halaman produk */
    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 15px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        gap: 10px;
        flex: 1;
    }

    .search-input {
        width: 300px;
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

    .filter-select {
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        color: #4b5563;
        padding: 6px 30px 6px 12px;
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

    /* Product Cell */
    .product-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-img {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
    }

    /* Badges */
    .badge-stok {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
    }
    .badge-stok-aman { background-color: #f3f4f6; color: #4b5563; }
    .badge-stok-menipis { background-color: #ffedd5; color: #9a3412; }
    .badge-stok-habis { background-color: #fee2e2; color: #991b1b; }

    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 11px;
    }
    .badge-status-aktif { background-color: #dcfce7; color: #166534; }
    .badge-status-nonaktif { background-color: #e5e7eb; color: #4b5563; }

    /* Actions */
    .action-icons {
        display: flex;
        gap: 12px;
    }
    
    .action-icons a {
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.2s;
    }
    
    .action-icons a:hover {
        color: #1a5ca6;
    }
    
    .action-icons a.text-danger:hover {
        color: #dc2626 !important;
    }

    /* Checkbox custom */
    .form-check-input {
        cursor: pointer;
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

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" style="font-size: 14px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Action Bar -->
<div class="action-bar">
    <form action="{{ route('produk.index') }}" method="GET" class="filter-group m-0" id="searchForm">
        <div class="search-input">
            <i class="fa-solid fa-magnifying-glass" style="z-index: 10;"></i>
            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari nama, SKU, atau barcode..." value="{{ request('search') }}">
        </div>
        <select name="kategori" class="form-select filter-select" style="width: auto;" onchange="this.form.submit()">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $kat)
                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>
        <select name="status" class="form-select filter-select" style="width: auto;" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
        </select>
        @if(request('tipe'))
            <input type="hidden" name="tipe" value="{{ request('tipe') }}">
        @endif
    </form>
    <div class="d-flex align-items-center gap-2 flex-shrink-0">
        @if(request('tipe') == 'manual')
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary text-decoration-none" style="padding: 6px 12px; border-radius: 6px;" title="Lihat Produk Fisik">
                <i class="fa-solid fa-box-open"></i>
            </a>
        @else
            <a href="{{ route('produk.index', ['tipe' => 'manual']) }}" class="btn btn-outline-info text-decoration-none" style="padding: 6px 12px; border-radius: 6px;" title="Lihat Produk Manual / Digital">
                <i class="fa-solid fa-mobile-screen-button"></i>
            </a>
        @endif
        <button type="button" onclick="cetakMassal()" class="btn btn-secondary text-decoration-none" style="padding: 6px 12px; border-radius: 6px;" title="Cetak Barcode">
            <i class="fa-solid fa-print"></i>
        </button>
        <a href="{{ route('produk.create') }}" class="btn btn-primary-custom text-decoration-none text-nowrap">
            <i class="fa-solid fa-plus me-1"></i> Tambah Produk
        </a>
    </div>
</div>

<script>
    function cetakMassal() {
        const checkboxes = document.querySelectorAll('.print-check:checked');
        if (checkboxes.length > 0) {
            // Jika ada yang dicentang, kirim spesifik item & quantity
            const items = [];
            checkboxes.forEach(cb => {
                const id = cb.value;
                const qtyInput = document.getElementById(`print-qty-${id}`);
                const qty = qtyInput ? qtyInput.value : 1;
                items.push({ id: id, qty: qty });
            });
            
            // Build URL
            const url = `{{ route('produk.barcode.massal') }}?items=${encodeURIComponent(JSON.stringify(items))}`;
            window.open(url, '_blank');
        } else {
            // Jika tidak ada yang dicentang, gunakan filter pencarian yang ada (semua masing-masing 1)
            if(confirm('Anda tidak mencentang produk apapun. Ingin mencetak semua produk berdasarkan filter saat ini?')) {
                const urlParams = new URLSearchParams(window.location.search);
                const printUrl = `{{ route('produk.barcode.massal') }}?${urlParams.toString()}`;
                window.open(printUrl, '_blank');
            }
        }
    }
</script>

<!-- Table -->
<div class="table-container">
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="padding-left: 20px;">Produk</th>
                <th>Kategori</th>
                <th>SKU</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Cetak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produks as $produk)
                @php
                    // Menghitung total stok di semua cabang
                    $totalStok = $produk->stokCabangs->sum('stok_sekarang');
                    $stokClass = 'badge-stok-aman';
                    
                    if($totalStok == 0) {
                        $stokClass = 'badge-stok-habis';
                    } elseif ($totalStok <= 10) {
                        $stokClass = 'badge-stok-menipis';
                    }

                    // Cek apakah produk digital
                    $namaKategori = strtolower($produk->kategori->nama_kategori ?? '');
                    $isDigital = in_array($namaKategori, ['pulsa', 'paket data', 'e-wallet', 'token pln', 'manual', 'digital']) || str_contains($namaKategori, 'digital') || str_contains($namaKategori, 'manual');
                @endphp
                <tr>
                    <td style="padding-left: 20px;">
                        <div class="product-cell">
                            <!-- Fallback image -->
                            <img src="{{ $produk->foto_produk ?? 'https://via.placeholder.com/40' }}" alt="{{ $produk->nama_produk }}" class="product-img">
                            <div class="d-flex flex-column">
                                <span class="fw-medium text-dark">{{ $produk->nama_produk }}</span>
                                @if($isDigital)
                                    <span class="badge bg-info text-white mt-1" style="font-size: 9px; width: fit-content;">Manual / Digital</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                    <td class="text-muted">{{ $produk->sku }}</td>
                    <td class="fw-medium text-dark">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge-stok {{ $stokClass }}">{{ $totalStok }} Unit</span>
                    </td>
                    <td>
                        @if($produk->status == 'aktif')
                            <span class="badge-status badge-status-aktif">Aktif</span>
                        @else
                            <span class="badge-status badge-status-nonaktif">Non-aktif</span>
                        @endif
                    </td>
                    <td>
                        @if(!$isDigital)
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" class="form-check-input print-check" value="{{ $produk->id_produk }}" style="width: 18px; height: 18px; margin-top: 0;">
                            <input type="number" id="print-qty-{{ $produk->id_produk }}" class="form-control form-control-sm text-center px-1" value="1" min="1" style="width: 50px;">
                        </div>
                        @else
                        <span class="text-muted" style="font-size: 12px;">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-icons">
                            @if(!$isDigital)
                            <a href="{{ route('produk.barcode', $produk->id_produk) }}" target="_blank" title="Cetak Barcode" class="text-secondary"><i class="fa-solid fa-barcode"></i></a>
                            @endif
                            <a href="{{ route('produk.show', $produk->id_produk) }}" title="Lihat"><i class="fa-regular fa-eye"></i></a>
                            <a href="{{ route('produk.edit', $produk->id_produk) }}" title="Edit" class="text-primary"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button type="button" class="text-danger btn-delete-produk border-0 bg-transparent p-0" title="Hapus"
                                data-id="{{ $produk->id_produk }}"
                                data-nama="{{ $produk->nama_produk }}">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-muted">Belum ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
        @if(isset($produks) && $produks->count() > 0)
            <div>Menampilkan <strong>{{ $produks->firstItem() }}-{{ $produks->lastItem() }}</strong> dari <strong>{{ $produks->total() }}</strong> produk</div>
            <div>
                {{ $produks->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-body p-4 text-center">
                <div class="text-danger mb-3">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Produk?</h5>
                <p class="text-muted mb-4" style="font-size: 14px;">Apakah Anda yakin ingin menghapus produk <strong id="deleteNamaProduk" class="text-dark"></strong> beserta data stoknya?</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                    <form id="formDelete" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="btnConfirmDelete" class="btn btn-danger" style="border-radius: 8px; font-weight: 500;">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Script untuk Modal Hapus
    function attachDeleteListeners() {
        // [Existing delete logic...]
        document.querySelectorAll('.btn-delete-produk').forEach(btn => {
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);
            
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                
                document.getElementById('deleteNamaProduk').innerText = nama;
                
                const formDelete = document.getElementById('formDelete');
                formDelete.action = "{{ url('/produk') }}/" + id;
                
                const modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));
                modalHapus.show();
            });
        });

        // Script untuk Modal Detail (Show)
        document.querySelectorAll('.btn-show-produk').forEach(btn => {
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);
            
            newBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                
                // Set loading state
                document.getElementById('detailNama').innerText = "Memuat...";
                document.getElementById('detailKategori').innerHTML = "<i class='fa-solid fa-tags me-2'></i> Memuat...";
                document.getElementById('detailStokTbody').innerHTML = "<tr><td colspan='2' class='text-center text-muted'>Memuat...</td></tr>";
                
                const modalDetail = new bootstrap.Modal(document.getElementById('modalDetail'));
                modalDetail.show();

                // Fetch data via AJAX
                fetch("{{ url('/produk') }}/" + id, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailNama').innerText = data.nama_produk;
                    document.getElementById('detailKategori').innerHTML = "<i class='fa-solid fa-tags me-2'></i> " + (data.kategori ? data.kategori.nama_kategori : '-');
                    document.getElementById('detailSku').innerText = data.sku || '-';
                    document.getElementById('detailBarcode').innerText = data.barcode_imei || '-';
                    
                    // Format harga
                    const formatRupiah = (angka) => 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
                    document.getElementById('detailHargaBeli').innerText = formatRupiah(data.harga_beli);
                    document.getElementById('detailHargaJual').innerText = formatRupiah(data.harga_jual);
                    
                    // Foto
                    document.getElementById('detailFoto').src = data.foto_produk ? data.foto_produk : "https://via.placeholder.com/150";
                    
                    // Status
                    const statusEl = document.getElementById('detailStatus');
                    if(data.status == 'aktif') {
                        statusEl.className = "badge-status badge-status-aktif d-inline-block px-3 py-2";
                        statusEl.innerText = "Aktif";
                    } else {
                        statusEl.className = "badge-status badge-status-nonaktif d-inline-block px-3 py-2";
                        statusEl.innerText = "Non-aktif";
                    }
                    
                    // Stok
                    let tbodyHtml = '';
                    let totalStok = 0;
                    if(data.stok_cabangs && data.stok_cabangs.length > 0) {
                        data.stok_cabangs.forEach(stok => {
                            tbodyHtml += `
                                <tr>
                                    <td style="font-size: 13px; padding: 10px;">${stok.cabang ? stok.cabang.nama_cabang : '-'}</td>
                                    <td class="text-center" style="font-size: 14px; padding: 10px; font-weight: 500;">${stok.stok_sekarang}</td>
                                </tr>
                            `;
                            totalStok += parseInt(stok.stok_sekarang);
                        });
                    } else {
                        tbodyHtml = "<tr><td colspan='2' class='text-center text-muted'>Tidak ada data stok</td></tr>";
                    }
                    
                    document.getElementById('detailStokTbody').innerHTML = tbodyHtml;
                    document.getElementById('detailTotalStok').innerText = totalStok;
                })
                .catch(error => {
                    console.error("Error fetching detail:", error);
                    document.getElementById('detailNama').innerText = "Gagal memuat data";
                });
            });
        });
    }

    attachDeleteListeners();
    // Script pencarian otomatis (Live Search)
    let searchTimer;
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            // Biarkan submit default jika ditekan enter untuk fallback,
            // Namun karena kita pakai ajax/live search, biarkan saja reload normal jika tidak mau AJAX.
            // Di halaman ini kita belum buat AJAX penuh seperti kategori, jadi pakai debounce submit.
        });
    }

    if (searchInput) {
        let val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                searchForm.submit();
            }, 600); // Tunggu 0.6 detik lalu submit otomatis
        });
    }
</script>
@endsection
