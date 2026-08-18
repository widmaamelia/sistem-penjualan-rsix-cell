<?php $__env->startSection('title', 'Detail Stok Opname'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .badge-status-pending { background-color: #fef3c7; color: #d97706; }
    .badge-status-approved { background-color: #dcfce7; color: #166534; }
    .badge-status-rejected { background-color: #fee2e2; color: #991b1b; }
    .badge-status { padding: 6px 16px; border-radius: 20px; font-weight: 600; font-size: 13px; text-transform: uppercase; }
</style>
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

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="<?php echo e(route('stok_opname.index')); ?>" class="btn btn-light bg-white" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    
    <?php if(auth()->user()->role === 'super' && $opname->status === 'pending'): ?>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalTolak" style="border-radius: 6px; font-weight: 500; padding: 6px 16px; font-size: 13.5px;">
                <i class="fa-solid fa-xmark me-1"></i> Tolak
            </button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalSetujui" style="border-radius: 6px; font-weight: 500; padding: 6px 16px; font-size: 13.5px;">
                <i class="fa-solid fa-check me-1"></i> Setujui
            </button>
        </div>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">
        <h6 class="text-muted mb-3 fw-bold text-uppercase" style="font-size: 13px;">Informasi Opname</h6>
        <table class="table table-borderless mb-0">
            <tr>
                <td class="text-muted" style="width: 150px;">Tanggal</td>
                <td class="fw-bold">: <?php echo e(\Carbon\Carbon::parse($opname->tanggal_opname)->format('d M Y')); ?></td>
            </tr>
            <tr>
                <td class="text-muted">Cabang</td>
                <td class="fw-bold text-primary">: <?php echo e($opname->cabang->nama_cabang); ?></td>
            </tr>
            <tr>
                <td class="text-muted">Pembuat</td>
                <td class="fw-bold">: <?php echo e($opname->user->name); ?></td>
            </tr>
            <tr>
                <td class="text-muted">Keterangan Umum</td>
                <td class="fw-medium">: <?php echo e($opname->keterangan ?? '-'); ?></td>
            </tr>
            <tr>
                <td class="text-muted">Status Saat Ini</td>
                <td>
                    : <span class="badge-status badge-status-<?php echo e($opname->status); ?>" style="padding: 4px 10px; font-size: 11px;">
                        <?php if($opname->status == 'approved'): ?> DISETUJUI
                        <?php elseif($opname->status == 'rejected'): ?> DITOLAK
                        <?php else: ?> PENDING <?php endif; ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 border-bottom">
        <h6 class="m-0 fw-bold">Detail Item Penyesuaian</h6>
    </div>
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4" style="font-size: 13px;">PRODUK</th>
                    <th class="py-3 px-4 text-center" style="font-size: 13px;">STOK SISTEM</th>
                    <th class="py-3 px-4 text-center" style="font-size: 13px;">STOK FISIK</th>
                    <th class="py-3 px-4 text-center" style="font-size: 13px;">SELISIH</th>
                    <th class="py-3 px-4" style="font-size: 13px;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $opname->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4">
                            <span class="text-muted" style="font-size: 11px;"><?php echo e($detail->produk->kode_produk); ?></span><br>
                            <span class="fw-bold"><?php echo e($detail->produk->nama_produk); ?></span>
                        </td>
                        <td class="px-4 text-center text-muted fw-bold"><?php echo e($detail->stok_sistem); ?></td>
                        <td class="px-4 text-center fs-6 fw-bold text-dark"><?php echo e($detail->stok_fisik); ?></td>
                        <td class="px-4 text-center">
                            <?php if($detail->selisih > 0): ?>
                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">+<?php echo e($detail->selisih); ?></span>
                            <?php elseif($detail->selisih < 0): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1"><?php echo e($detail->selisih); ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">0</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 text-muted"><?php echo e($detail->keterangan ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Tidak ada item yang diinput.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if(auth()->user()->role === 'super' && $opname->status === 'pending'): ?>
<!-- Modal Tolak -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fa-solid fa-circle-xmark text-danger" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Tolak Opname?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin menolak stok opname ini?</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                <form action="<?php echo e(route('stok_opname.reject', $opname->id_stok_opname)); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger" style="border-radius: 8px; font-weight: 500;">Ya, Tolak</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Setujui -->
<div class="modal fade" id="modalSetujui" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fa-solid fa-circle-check text-success" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Setujui Opname?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin menyetujui stok opname ini? Stok pada sistem akan langsung berubah mengikuti stok fisik.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                <form action="<?php echo e(route('stok_opname.approve', $opname->id_stok_opname)); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success" style="border-radius: 8px; font-weight: 500;">Ya, Setujui</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/stok_opname/show.blade.php ENDPATH**/ ?>