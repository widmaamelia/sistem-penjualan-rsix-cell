<?php $__env->startSection('title', 'Kas Keluar'); ?>

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
        padding-left: 40px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .btn-primary-custom {
        background-color: #1a5ca6;
        border-color: #1a5ca6;
        color: white;
        font-weight: 500;
        border-radius: 8px;
        padding: 8px 16px;
    }

    .btn-primary-custom:hover {
        background-color: #154a85;
        color: white;
    }

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

    /* Ringkasan di bawah tabel */
    .summary-panel {
        border-top: 1px solid #e5e7eb;
        background-color: #f9fafb;
        padding: 18px 20px 0 20px;
    }
    .summary-panel .summary-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
    }
    .summary-panel .summary-total {
        font-size: 26px;
        font-weight: 700;
        color: #dc2626;
        line-height: 1.2;
        margin-top: 2px;
    }
    .summary-panel .summary-meta {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
    .summary-panel .summary-breakdown {
        display: flex;
        flex-wrap: wrap;
        gap: 28px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px dashed #e5e7eb;
    }
    .summary-panel .summary-item {
        min-width: 170px;
    }
    .summary-panel .summary-item-head {
        font-size: 11px;
        font-weight: 600;
        color: #4b5563;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .summary-panel .summary-item-head .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
    .summary-panel .summary-item-value {
        font-size: 16px;
        font-weight: 700;
        margin-top: 3px;
    }
    .summary-panel .summary-item-note {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 1px;
    }
    .summary-panel .summary-bar {
        display: flex;
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        background-color: #e5e7eb;
        margin-top: 16px;
    }

    @media (min-width: 992px) {
        .summary-panel {
            display: grid;
            grid-template-columns: minmax(240px, 1fr) auto;
            grid-template-areas: "main breakdown" "bar bar";
            column-gap: 32px;
            align-items: center;
        }
        .summary-panel .summary-main { grid-area: main; }
        .summary-panel .summary-breakdown {
            grid-area: breakdown;
            margin-top: 0;
            padding-top: 0;
            border-top: 0;
        }
        .summary-panel .summary-bar { grid-area: bar; }
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

<!-- Header -->
<div class="d-flex justify-content-end align-items-center mb-3">
    <?php if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super'): ?>
    <a href="<?php echo e(route('kas_keluar.create')); ?>" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">
        <i class="fa-solid fa-plus me-1"></i> Catat Kas Keluar
    </a>
    <?php endif; ?>
</div>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Filter Card -->
<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="<?php echo e(route('kas_keluar.index')); ?>" method="GET" class="row g-3 align-items-end" id="filterForm">
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 12px;">Pencarian</label>
                <div class="position-relative">
                    <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 13px;"></i>
                    <input type="text" name="search" class="form-control" placeholder="Cari keterangan..." value="<?php echo e(request('search')); ?>" style="border-radius: 6px; padding: 6px 12px 6px 32px; font-size: 13.5px;" onchange="document.getElementById('filterForm').submit()">
                </div>
            </div>
            
            <?php if(auth()->user()->role === 'super'): ?>
            <div class="col-md-3">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Cabang</label>
                <select name="id_cabang" class="form-select" style="border-radius: 6px; font-size: 13.5px; padding: 6px 32px 6px 12px;" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Cabang</option>
                    <?php $__currentLoopData = $cabangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cabang->id_cabang); ?>" <?php echo e(request('id_cabang') == $cabang->id_cabang ? 'selected' : ''); ?>><?php echo e($cabang->nama_cabang); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <?php endif; ?>

            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Rentang Tanggal</label>
                <div class="position-relative">
                    <i class="fa-regular fa-calendar" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 13px;"></i>
                    <input type="text" name="date_range" id="date_range" class="form-control bg-white" placeholder="Pilih Rentang Tanggal" value="<?php echo e(request('date_range')); ?>" style="border-radius: 6px; font-size: 13.5px; padding: 6px 12px 6px 32px; cursor: pointer;">
                </div>
            </div>

            <div class="col-md-auto ms-auto d-flex gap-2">
                <?php if(request()->hasAny(['search', 'id_cabang', 'date_range']) && array_filter(request()->only(['search', 'id_cabang', 'date_range']))): ?>
                    <a href="<?php echo e(route('kas_keluar.index')); ?>" class="btn btn-light border" style="border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Reset</a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        flatpickr("#date_range", {
            mode: "range",
            dateFormat: "Y-m-d",
            placeholder: "Pilih Rentang Tanggal",
            onChange: function(selectedDates, dateStr, instance) {
                // Submit form otomatis setelah rentang tanggal dipilih lengkap (2 tanggal)
                if (selectedDates.length === 2) {
                    document.getElementById('filterForm').submit();
                }
            }
        });
    });
</script>

<!-- Table -->
<div class="table-container shadow-sm">
    <table class="table mb-0">
        <thead>
            <tr>
                <th style="width: 60px; padding-left: 20px;">No</th>
                <th>Tanggal & Waktu</th>
                <th>Cabang</th>
                <th>Jumlah Pengeluaran</th>
                <th>Tipe Pengeluaran</th>
                <?php if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super'): ?>
                <th style="width: 80px;">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $kasKeluars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isAutoRestock = str_contains(strtolower($item->keterangan), 'restock');
                    $isAutoOpname = str_contains(strtolower($item->keterangan), 'opname');
                    $isManual = !$isAutoRestock && !$isAutoOpname;
                    $cabangName = $item->cabang->nama_cabang ?? ($item->shift->cabang->nama_cabang ?? 'Cabang Dihapus');
                ?>
                <tr>
                    <td class="text-muted" style="padding-left: 20px;"><?php echo e($kasKeluars->firstItem() + $index); ?></td>
                    <td class="fw-medium text-dark">
                        <?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d M Y, H:i')); ?> WIB
                    </td>
                    <td>
                        <span class="text-primary fw-medium"><?php echo e($cabangName); ?></span>
                    </td>
                    <td class="fw-bold text-danger">
                        Rp <?php echo e(number_format($item->jumlah_pengeluaran, 0, ',', '.')); ?>

                    </td>
                    <td>
                        <?php if($isAutoRestock): ?>
                            <span class="badge bg-info bg-opacity-10 text-info px-2 py-1" style="font-size: 11px;">Sistem (Restock)</span>
                        <?php elseif($isAutoOpname): ?>
                            <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1" style="font-size: 11px;">Sistem (Opname)</span>
                        <?php else: ?>
                            <span class="badge bg-success bg-opacity-10 text-success px-2 py-1" style="font-size: 11px;">Manual (Operasional)</span>
                        <?php endif; ?>
                    </td>
                    <?php if(auth()->user()->role === 'admin cabang' || auth()->user()->role === 'super'): ?>
                    <td>
                        <div class="action-icons align-items-center">
                            <a href="<?php echo e(route('kas_keluar.show', $item->id_kas_keluar)); ?>" class="text-primary" title="Detail">
                                <i class="fa-regular fa-eye"></i>
                            </a>

                            <?php if($isManual): ?>
                                <form action="<?php echo e(route('kas_keluar.destroy', $item->id_kas_keluar)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan pengeluaran ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-danger" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted ms-1" style="font-size: 11px;" title="Terkunci (Sistem)"><i class="fa-solid fa-lock"></i></span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">Belum ada catatan pengeluaran kas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($ringkasan['jumlah_semua'] > 0): ?>
    <?php
        $namaBulan = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                      '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                      '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];

        if (request('tanggal')) {
            $periode = \Carbon\Carbon::parse(request('tanggal'))->translatedFormat('d F Y');
        } elseif (request('bulan') && request('tahun')) {
            $periode = ($namaBulan[request('bulan')] ?? '') . ' ' . request('tahun');
        } elseif (request('bulan')) {
            $periode = 'Bulan ' . ($namaBulan[request('bulan')] ?? '') . ' (semua tahun)';
        } elseif (request('tahun')) {
            $periode = 'Tahun ' . request('tahun');
        } else {
            $periode = 'Semua periode';
        }

        $persenOtomatis = $ringkasan['total'] > 0 ? round($ringkasan['otomatis'] / $ringkasan['total'] * 100) : 0;
        $persenManual = $ringkasan['total'] > 0 ? 100 - $persenOtomatis : 0;
    ?>

    <div class="bg-light border-top p-3 d-flex justify-content-between align-items-center" style="font-size: 13px;">
        <div>
            <span class="text-muted">Total Pengeluaran (<?php echo e($periode); ?>):</span>
            <strong class="text-danger ms-1 fs-6">Rp <?php echo e(number_format($ringkasan['total'], 0, ',', '.')); ?></strong>
            <span class="text-muted ms-2">(<?php echo e(number_format($ringkasan['jumlah_semua'], 0, ',', '.')); ?> catatan)</span>
            
            <?php if(request()->filled('search')): ?>
                <span class="text-muted ms-1">&middot; Pencarian "<?php echo e(request('search')); ?>"</span>
            <?php endif; ?>
        </div>
        <div class="text-muted">
            <span class="me-3"><i class="fa-solid fa-circle text-info" style="font-size: 8px; vertical-align: middle;"></i> Sistem: Rp <?php echo e(number_format($ringkasan['otomatis'], 0, ',', '.')); ?></span>
            <span><i class="fa-solid fa-circle text-success" style="font-size: 8px; vertical-align: middle;"></i> Manual: Rp <?php echo e(number_format($ringkasan['manual'], 0, ',', '.')); ?></span>
        </div>
    </div>
    <?php endif; ?>

    <!-- Pagination -->
    <div class="bg-white border-top py-3 px-4 d-flex justify-content-between align-items-center" style="font-size: 13px; color: #6b7280;">
        <?php if($kasKeluars->count() > 0): ?>
            <div>Menampilkan <strong><?php echo e($kasKeluars->firstItem()); ?>-<?php echo e($kasKeluars->lastItem()); ?></strong> dari <strong><?php echo e($kasKeluars->total()); ?></strong> pengeluaran</div>
            <div>
                <?php echo e($kasKeluars->links('pagination::bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div>Menampilkan 0 data</div>
        <?php endif; ?>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/kas_keluar/index.blade.php ENDPATH**/ ?>