<?php $__env->startSection('title', 'Riwayat Stok Opname'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .badge-status-pending { background-color: #fef3c7; color: #d97706; }
    .badge-status-approved { background-color: #dcfce7; color: #166534; }
    .badge-status-rejected { background-color: #fee2e2; color: #991b1b; }
    .badge-status { padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 11px; text-transform: uppercase; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#date_range", {
        mode: "range",
        dateFormat: "Y-m-d",
        placeholder: "Pilih Rentang Tanggal"
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="d-flex justify-content-end align-items-center mb-3">
    <?php if(auth()->user()->role === 'admin cabang'): ?>
        <a href="<?php echo e(route('stok_opname.create')); ?>" class="btn btn-primary" style="background-color: #1a5ca6; border-radius: 6px; font-size: 13.5px; padding: 6px 14px;">
            <i class="fa-solid fa-plus me-1"></i> Buat Stok Opname
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="<?php echo e(route('stok_opname.index')); ?>" method="GET" class="row g-3 align-items-end" id="filterForm">
            <?php if(auth()->user()->role === 'super'): ?>
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Cabang</label>
                <select name="id_cabang" class="form-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="">Semua Cabang</option>
                    <?php $__currentLoopData = $cabangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cabang->id_cabang); ?>" <?php echo e(request('id_cabang') == $cabang->id_cabang ? 'selected' : ''); ?>>
                            <?php echo e($cabang->nama_cabang); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Rentang Tanggal</label>
                <input type="text" name="date_range" id="date_range" class="form-control" placeholder="Pilih Rentang Tanggal" value="<?php echo e(request('date_range')); ?>">
            </div>
            <?php else: ?>
            <div class="col-md-10">
                <label class="form-label text-muted" style="font-size: 12px;">Filter Rentang Tanggal</label>
                <input type="text" name="date_range" id="date_range" class="form-control" placeholder="Pilih Rentang Tanggal" value="<?php echo e(request('date_range')); ?>">
            </div>
            <?php endif; ?>
            
            <div class="col-md-2 d-grid gap-2">
                <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6;">Terapkan Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">NO</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">TANGGAL</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">CABANG</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">PEMBUAT</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">STATUS</th>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $opnames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opname): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 fw-bold"><?php echo e(($opnames->currentPage() - 1) * $opnames->perPage() + $loop->iteration); ?></td>
                        <td class="px-4"><?php echo e(\Carbon\Carbon::parse($opname->tanggal_opname)->format('d M Y')); ?></td>
                        <td class="px-4 text-primary fw-medium"><?php echo e($opname->cabang->nama_cabang); ?></td>
                        <td class="px-4"><?php echo e($opname->user->name); ?></td>
                        <td class="px-4">
                            <span class="badge-status badge-status-<?php echo e($opname->status); ?>">
                                <?php if($opname->status == 'approved'): ?> DISETUJUI
                                <?php elseif($opname->status == 'rejected'): ?> DITOLAK
                                <?php else: ?> PENDING <?php endif; ?>
                            </span>
                        </td>
                        <td class="px-4">
                            <a href="<?php echo e(route('stok_opname.show', $opname->id_stok_opname)); ?>" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                <i class="fa-regular fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat stok opname.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($opnames->hasPages()): ?>
        <div class="card-footer bg-white border-top py-3 px-4">
            <?php echo e($opnames->links('pagination::bootstrap-5')); ?>

        </div>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#date_range", {
        mode: "range",
        dateFormat: "Y-m-d",
        placeholder: "Pilih Rentang Tanggal"
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/stok_opname/index.blade.php ENDPATH**/ ?>