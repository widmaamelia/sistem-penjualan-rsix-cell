<?php $__env->startSection('title', 'Pengguna'); ?>

<?php $__env->startSection('styles'); ?>
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

    /* Avatar Initials */
    .avatar-initials {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #e0e7ff;
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .user-info-cell {
        display: flex;
        align-items: center;
    }

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

<!-- Action Bar -->
<div class="action-bar mt-4">
    <form action="<?php echo e(route('pengguna.index')); ?>" method="GET" class="search-input m-0" id="searchForm">
        <i class="fa-solid fa-magnifying-glass" style="z-index: 10;"></i>
        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari nama atau email pengguna..." value="<?php echo e(request('search')); ?>">
    </form>
    <div>
        <a href="<?php echo e(route('pengguna.create')); ?>" class="btn btn-primary-custom text-decoration-none">
            <i class="fa-solid fa-plus me-1"></i> Tambah Pengguna
        </a>
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="padding-left: 20px; width: 60px;">No</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Cabang</th>
                <th>Status</th>
                <th style="width: 100px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = ($penggunas->currentPage() - 1) * $penggunas->perPage() + 1; ?>
            <?php $__empty_1 = true; $__currentLoopData = $penggunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $initials = collect(explode(' ', $user->name))->map(function($segment) { return strtoupper(substr($segment, 0, 1)); })->take(2)->join('');
                    
                    // Styling spesifik untuk role tertentu
                    if ($user->role == 'super') {
                        $roleName = 'Super Admin';
                        $avatarBg = '#e0e7ff'; $avatarColor = '#4f46e5';
                    } elseif ($user->role == 'admin cabang') {
                        $roleName = 'Admin Cabang';
                        $avatarBg = '#fce7f3'; $avatarColor = '#be185d';
                    } else {
                        $roleName = 'Karyawan';
                        $avatarBg = '#ffedd5'; $avatarColor = '#c2410c';
                    }
                ?>
                <tr>
                    <td style="padding-left: 20px;" class="text-muted"><?php echo e($no++); ?></td>
                    <td>
                        <div class="user-info-cell">
                            <div class="avatar-initials" style="background-color: <?php echo e($avatarBg); ?>; color: <?php echo e($avatarColor); ?>;">
                                <?php echo e($initials); ?>

                            </div>
                            <span class="fw-bold text-dark"><?php echo e($user->name); ?></span>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo e($user->email); ?></td>
                    <td class="text-dark fw-medium"><?php echo e($roleName); ?></td>
                    <td class="text-muted"><?php echo e($user->cabang ? $user->cabang->nama_cabang : 'Pusat'); ?></td>
                    <td>
                        <div class="form-check form-switch" style="padding-left: 2.5em;">
                            <input class="form-check-input toggle-status" type="checkbox" role="switch" data-id="<?php echo e($user->id_user); ?>" data-type="pengguna" <?php echo e(strtolower($user->status) == 'aktif' ? 'checked' : ''); ?> style="cursor: pointer; width: 40px; height: 20px;">
                        </div>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="<?php echo e(route('pengguna.show', $user->id_user)); ?>" title="Lihat"><i class="fa-regular fa-eye"></i></a>
                            <a href="<?php echo e(route('pengguna.edit', $user->id_user)); ?>" class="text-primary" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button type="button" class="text-danger btn-delete-pengguna" title="Hapus"
                                data-id="<?php echo e($user->id_user); ?>"
                                data-nama="<?php echo e($user->name); ?>">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
        <?php if(isset($penggunas) && $penggunas->count() > 0): ?>
            <div>Menampilkan <?php echo e($penggunas->firstItem()); ?> dari <?php echo e($penggunas->total()); ?> Pengguna</div>
            <div>
                <?php echo e($penggunas->links('pagination::bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div>Menampilkan 0 data</div>
        <?php endif; ?>
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
                <h5 class="fw-bold mb-2">Hapus Pengguna?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin menghapus pengguna <strong id="deleteNamaPengguna"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                <form id="formDelete" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger" style="border-radius: 8px; font-weight: 500;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Fitur Delete
    document.querySelectorAll('.btn-delete-pengguna').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            document.getElementById('deleteNamaPengguna').innerText = nama;
            document.getElementById('formDelete').action = "<?php echo e(url('/pengguna')); ?>/" + id;
            new bootstrap.Modal(document.getElementById('modalHapus')).show();
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
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/pengguna/index.blade.php ENDPATH**/ ?>