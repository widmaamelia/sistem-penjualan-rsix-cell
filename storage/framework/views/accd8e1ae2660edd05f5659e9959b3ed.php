<?php $__env->startSection('title', 'Kategori Produk'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Styling khusus untuk halaman kategori (Identik dengan Produk) */
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

    /* Actions */
    .action-icons {
        display: flex;
        gap: 12px;
    }
    
    .action-icons button {
        background: none;
        border: none;
        padding: 0;
        color: #6b7280;
        font-size: 14px;
        transition: color 0.2s;
        cursor: pointer;
    }
    
    .action-icons button.text-primary:hover {
        color: #1a5ca6 !important;
    }
    
    .action-icons button.text-danger:hover {
        color: #dc2626 !important;
    }

    /* Checkbox custom */
    .form-check-input {
        cursor: pointer;
    }
    
    /* Modal Custom */
    .modal-content {
        border-radius: 12px;
        border: none;
    }
    .modal-header {
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 20px;
    }
    .modal-footer {
        border-top: 1px solid #e5e7eb;
        padding: 15px 20px;
    }
    .form-control:focus {
        border-color: #1a5ca6;
        box-shadow: 0 0 0 3px rgba(26,92,166,0.1);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Notifikasi -->
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="font-size: 14px;">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 14px;">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" style="font-size: 14px;">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Action Bar -->
<div class="action-bar">
    <form id="searchForm" action="<?php echo e(route('kategori.index')); ?>" method="GET" class="search-input m-0">
        <i class="fa-solid fa-magnifying-glass" style="z-index: 10;"></i>
        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Cari kategori..." value="<?php echo e(request('search')); ?>" autofocus>
    </form>
    <div>
        <a href="<?php echo e(route('kategori.create')); ?>" class="btn btn-primary-custom text-decoration-none">
            <i class="fa-solid fa-plus me-1"></i> Tambah Kategori
        </a>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="width: 60px; padding-left: 20px;">No</th>
                <th>Nama Kategori</th>
                <th>Total Produk</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-muted" style="padding-left: 20px;"><?php echo e($kategoris->firstItem() + $index); ?></td>
                    <td class="fw-medium text-dark"><?php echo e($kategori->nama_kategori); ?></td>
                    <td>
                        <span class="badge bg-secondary" style="font-weight: 500;">
                            <?php echo e($kategori->produks_count); ?> Produk
                        </span>
                    </td>
                    <td>
                        <div class="action-icons">
                            <!-- Edit Button -->
                            <a href="<?php echo e(route('kategori.edit', $kategori->id_kategori)); ?>" class="text-primary" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <!-- Delete Button -->
                            <button type="button" class="text-danger btn-delete-kategori" title="Hapus"
                                data-id="<?php echo e($kategori->id_kategori); ?>"
                                data-nama="<?php echo e($kategori->nama_kategori); ?>"
                                data-produk="<?php echo e($kategori->produks_count); ?>">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
        <?php if($kategoris->count() > 0): ?>
            <div>Menampilkan <strong><?php echo e($kategoris->firstItem()); ?>-<?php echo e($kategoris->lastItem()); ?></strong> dari <strong><?php echo e($kategoris->total()); ?></strong> kategori</div>
            <div>
                <?php echo e($kategoris->links('pagination::bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div>Menampilkan 0 data</div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fa-solid fa-triangle-exclamation text-danger" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Kategori?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin menghapus kategori <strong id="deleteNamaKategori"></strong>?</p>
                <p id="deleteWarning" class="text-danger mt-2" style="font-size: 12px; display: none;">Kategori ini tidak dapat dihapus karena masih digunakan oleh produk.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                <form id="formDelete" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" id="btnConfirmDelete" class="btn btn-danger" style="border-radius: 8px; font-weight: 500;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Fungsi untuk memasang event listener ke tombol Hapus
    function attachDeleteListeners() {
        document.querySelectorAll('.btn-delete-kategori').forEach(btn => {
            // Hapus listener lama jika ada (mencegah double)
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);
            
            newBtn.addEventListener('click', function() {
                // Tombol yang diklik (menggunakan event manual)
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const produkCount = parseInt(this.getAttribute('data-produk'));
                
                document.getElementById('deleteNamaKategori').innerText = nama;
                
                const warningEl = document.getElementById('deleteWarning');
                const btnDelete = document.getElementById('btnConfirmDelete');
                
                if (produkCount > 0) {
                    warningEl.style.display = 'block';
                    btnDelete.disabled = true;
                } else {
                    warningEl.style.display = 'none';
                    btnDelete.disabled = false;
                }

                const formDelete = document.getElementById('formDelete');
                formDelete.action = "<?php echo e(url('/kategori')); ?>/" + id;
                
                // Munculkan modal secara manual
                const modalHapus = new bootstrap.Modal(document.getElementById('modalHapus'));
                modalHapus.show();
            });
        });
    }

    // Panggil saat halaman pertama kali dimuat
    attachDeleteListeners();

    // Script pencarian otomatis (Live Search) tanpa reload halaman (AJAX)
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Cegah reload halaman saat tekan Enter
        });
    }

    if (searchInput) {
        // Pindahkan kursor ke ujung teks saat memuat ulang halaman
        let val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;

        searchInput.addEventListener('input', function() {
            let query = this.value;
            fetch("<?php echo e(route('kategori.index')); ?>?search=" + encodeURIComponent(query), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, "text/html");
                
                // Update tabel
                let tbody = document.querySelector('tbody');
                let newTbody = doc.querySelector('tbody');
                if (tbody && newTbody) {
                    tbody.innerHTML = newTbody.innerHTML;
                }
                
                // Update pagination
                let pagination = document.querySelector('.bg-white.border-top');
                let newPagination = doc.querySelector('.bg-white.border-top');
                if (pagination && newPagination) {
                    pagination.innerHTML = newPagination.innerHTML;
                }
                
                // Pasang kembali event listener Hapus ke tombol-tombol baru hasil AJAX
                attachDeleteListeners();
            });
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/kategori/index.blade.php ENDPATH**/ ?>