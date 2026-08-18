<?php $__env->startSection('title', auth()->user()->role === 'super' ? 'Stok Semua Cabang' : 'Stok Cabang'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Summary Cards */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }

    .summary-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .summary-icon-blue { background-color: #eff6ff; color: #3b82f6; }
    .summary-icon-red { background-color: #fef2f2; color: #ef4444; }
    .summary-icon-gray { background-color: #f3f4f6; color: #4b5563; }

    .summary-info h6 {
        font-size: 11px;
        text-transform: uppercase;
        font-weight: 700;
        color: #6b7280;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .summary-info h3 {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    /* Action Bar */
    .action-bar {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .filter-select {
        border-radius: 6px;
        border: 1px solid #d1d5db;
        padding: 6px 12px;
        font-size: 13.5px;
        min-width: 200px;
        background-color: #f9fafb;
    }

    .filter-info {
        font-size: 13px;
        color: #6b7280;
    }
    
    .filter-badge {
        background-color: #eff6ff;
        color: #1a5ca6;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
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
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
    }
    
    .badge-status-aman { background-color: #dcfce7; color: #166534; }
    .badge-status-rendah { background-color: #ffedd5; color: #c2410c; }
    .badge-status-habis { background-color: #fee2e2; color: #991b1b; }

    .product-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-img {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
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
        font-size: 15px;
        transition: color 0.2s;
        cursor: pointer;
        text-decoration: none;
    }
    
    .action-icons a:hover {
        color: #1a5ca6;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-end align-items-center mb-3">
    <div class="d-flex gap-2">
        <?php if(in_array(auth()->user()->role, ['super', 'admin cabang'])): ?>
            <a href="<?php echo e(route('stok.tambah-form')); ?>" class="btn btn-primary text-decoration-none" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">
                <i class="fa-solid fa-plus me-1"></i> Tambah Stok (Restock)
            </a>
        <?php endif; ?>

    </div>
</div>

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

<!-- Summary Cards -->
<div class="summary-cards">
    <div class="summary-card">
        <div class="summary-icon summary-icon-blue">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <div class="summary-info">
            <h6>Total Produk</h6>
            <h3><?php echo e(number_format($totalProduk, 0, ',', '.')); ?></h3>
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-icon summary-icon-red">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="summary-info">
            <h6 style="color: #ef4444;">Stok Rendah</h6>
            <h3 style="color: #ef4444;"><?php echo e(number_format($stokRendah, 0, ',', '.')); ?></h3>
        </div>
    </div>
    <div class="summary-card">
        <div class="summary-icon summary-icon-gray">
            <i class="fa-solid fa-ban"></i>
        </div>
        <div class="summary-info">
            <h6>Stok Habis</h6>
            <h3><?php echo e(number_format($stokHabis, 0, ',', '.')); ?></h3>
        </div>
    </div>
</div>

<!-- Action Bar (Filter) -->
<div class="action-bar">
    <form action="<?php echo e(route('stok.index')); ?>" method="GET" class="filter-group m-0" id="filterForm">
        <i class="fa-solid fa-building text-muted"></i>
        <select name="id_cabang" class="form-select filter-select" onchange="document.getElementById('filterForm').submit()">
            <option value="">Semua Cabang</option>
            <?php $__currentLoopData = $cabangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cabang->id_cabang); ?>" <?php echo e(request('id_cabang') == $cabang->id_cabang ? 'selected' : ''); ?>>
                    <?php echo e($cabang->nama_cabang); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        
        <select name="status_stok" class="form-select filter-select ms-2" onchange="document.getElementById('filterForm').submit()">
            <option value="">Semua Status Stok</option>
            <option value="aman" <?php echo e(request('status_stok') == 'aman' ? 'selected' : ''); ?>>Stok Aman</option>
            <option value="rendah" <?php echo e(request('status_stok') == 'rendah' ? 'selected' : ''); ?>>Stok Rendah</option>
            <option value="habis" <?php echo e(request('status_stok') == 'habis' ? 'selected' : ''); ?>>Stok Habis</option>
        </select>

        <!-- Retain search term if exists -->
        <?php if(request('search')): ?>
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
        <?php endif; ?>
    </form>
    
    <div class="filter-info">
        <?php if($id_cabang): ?>
            <span class="filter-badge"><i class="fa-solid fa-circle-info me-1"></i> STOK CABANG TERPILIH</span> 
        <?php endif; ?>
        Menampilkan <?php echo e($produks->firstItem() ?? 0); ?>-<?php echo e($produks->lastItem() ?? 0); ?> dari <?php echo e($produks->total()); ?> produk
    </div>
</div>

<!-- Table -->
<div class="table-container">
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="padding-left: 20px; width: 60px;">No</th>
                <th>SKU</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th class="text-center">Total Stok</th>
                <th>Status</th>
                <th style="width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = ($produks->currentPage() - 1) * $produks->perPage() + 1; ?>
            <?php $__empty_1 = true; $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $totalSeluruhStok = 0;
                    $stokCabangTerpilih = 0;
                    $status = 'aman'; // aman, rendah, habis
                    $maxMinStok = 0;

                    foreach ($produk->stokCabangs as $stok) {
                        $totalSeluruhStok += $stok->stok_sekarang;
                        if ($stok->stok_minimum > $maxMinStok) $maxMinStok = $stok->stok_minimum;
                        
                        if ($id_cabang && $stok->id_cabang == $id_cabang) {
                            $stokCabangTerpilih = $stok->stok_sekarang;
                        }
                    }

                    // Tentukan stok mana yang jadi acuan status
                    $stokAcuan = $id_cabang ? $stokCabangTerpilih : $totalSeluruhStok;
                    
                    if ($stokAcuan <= 0) {
                        $status = 'habis';
                    } elseif ($stokAcuan <= $maxMinStok) {
                        // Cukup kasar, tapi memenuhi ilustrasi visual stok rendah
                        $status = 'rendah';
                    }
                ?>
                <tr>
                    <td style="padding-left: 20px;" class="text-muted"><?php echo e($no++); ?></td>
                    <td class="fw-bold" style="font-size: 12px;"><?php echo e($produk->sku ?? '-'); ?></td>
                    <td>
                        <div class="product-cell">
                            <img src="<?php echo e($produk->foto_produk ?? 'https://via.placeholder.com/40'); ?>" alt="Foto" class="product-img">
                            <div>
                                <span class="fw-bold text-dark d-block"><?php echo e(Str::limit($produk->nama_produk, 30)); ?></span>
                                <?php if($produk->kategori && $produk->kategori->nama_kategori == 'Pulsa & Paket Data'): ?>
                                    <small class="text-primary fw-bold" style="font-size: 10px;"><?php echo e(strtoupper(explode(' ', $produk->nama_produk)[1] ?? 'PROVIDER')); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo e($produk->kategori->nama_kategori ?? '-'); ?></td>
                    <td class="text-center fw-bold fs-6" style="<?php echo e($totalSeluruhStok <= 0 ? 'color: #ef4444;' : 'color: #111827;'); ?>"><?php echo e($totalSeluruhStok); ?></td>
                    <td>
                        <?php if($status == 'aman'): ?>
                            <span class="badge-status badge-status-aman">Stok Aman</span>
                        <?php elseif($status == 'rendah'): ?>
                            <span class="badge-status badge-status-rendah">Stok Rendah</span>
                        <?php else: ?>
                            <span class="badge-status badge-status-habis">Habis</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="action-icons">
                            <a href="<?php echo e(route('produk.show', $produk->id_produk)); ?>" title="Lihat"><i class="fa-regular fa-eye"></i></a>
                            
                            <a href="<?php echo e(route('stok.history', $produk->id_produk)); ?>" title="Riwayat Stok"><i class="fa-solid fa-clock-rotate-left"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-box-open mb-3" style="font-size: 40px; color: #d1d5db;"></i>
                        <br>
                        Tidak ada data produk/stok yang ditemukan.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
        <div>
            <?php if($produks->previousPageUrl()): ?>
                <a href="<?php echo e($produks->previousPageUrl()); ?>" class="text-decoration-none text-muted"><i class="fa-solid fa-chevron-left me-1"></i> Sebelumnya</a>
            <?php else: ?>
                <span class="text-muted opacity-50"><i class="fa-solid fa-chevron-left me-1"></i> Sebelumnya</span>
            <?php endif; ?>
        </div>
        
        <div>
            <?php echo e($produks->links('pagination::bootstrap-5')); ?>

        </div>

        <div>
            <?php if($produks->nextPageUrl()): ?>
                <a href="<?php echo e($produks->nextPageUrl()); ?>" class="text-decoration-none" style="color: #1a5ca6;">Berikutnya <i class="fa-solid fa-chevron-right ms-1"></i></a>
            <?php else: ?>
                <span class="text-muted opacity-50">Berikutnya <i class="fa-solid fa-chevron-right ms-1"></i></span>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/stok/index.blade.php ENDPATH**/ ?>