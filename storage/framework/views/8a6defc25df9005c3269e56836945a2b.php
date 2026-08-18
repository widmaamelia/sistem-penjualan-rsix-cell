<?php $__env->startSection('title', 'Buat Stok Opname'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 25px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <a href="<?php echo e(route('stok_opname.index')); ?>" class="btn btn-light" style="border-radius: 8px; border: 1px solid #e5e7eb; color: #4b5563; padding: 8px 14px;" title="Kembali">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</div>

<div class="form-container shadow-sm">
    <h6 class="text-uppercase fw-bold mb-4" style="font-size:12px; color: #1a5ca6; letter-spacing:0.5px;">Buat Stok Opname Baru</h6>
    <form action="<?php echo e(route('stok_opname.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <h5 class="fw-bold mb-3">Daftar Produk</h5>
        <div class="alert alert-info py-2" style="font-size: 13px;">
            <i class="fa-solid fa-circle-info me-1"></i> Isi kolom <strong>Stok Fisik</strong> hanya pada barang yang ingin disesuaikan. Kosongkan jika stok sudah sesuai.
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th style="font-size: 13px;">Kode / Nama Produk</th>
                        <th style="font-size: 13px; width: 120px;" class="text-center">Stok Sistem</th>
                        <th style="font-size: 13px; width: 150px;">Stok Fisik <span class="text-danger">*</span></th>
                        <th style="font-size: 13px; width: 120px;" class="text-center">Selisih</th>
                        <th style="font-size: 13px; width: 200px;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $produks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $produk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $stokSistem = $produk->stokCabangs->first() ? $produk->stokCabangs->first()->stok_sekarang : 0;
                        ?>
                        <tr>
                            <td class="align-middle">
                                <span class="text-muted" style="font-size: 11px;"><?php echo e($produk->kode_produk); ?></span><br>
                                <span class="fw-bold"><?php echo e($produk->nama_produk); ?></span>
                                <input type="hidden" name="produks[<?php echo e($index); ?>][id_produk]" value="<?php echo e($produk->id_produk); ?>">
                                <input type="hidden" name="produks[<?php echo e($index); ?>][stok_sistem]" value="<?php echo e($stokSistem); ?>" id="sistem_<?php echo e($index); ?>">
                            </td>
                            <td class="align-middle text-center fs-5 fw-bold text-secondary">
                                <?php echo e($stokSistem); ?>

                            </td>
                            <td class="align-middle">
                                <input type="number" name="produks[<?php echo e($index); ?>][stok_fisik]" id="fisik_<?php echo e($index); ?>" class="form-control form-control-sm text-center input-fisik" data-index="<?php echo e($index); ?>" placeholder="0" min="0">
                            </td>
                            <td class="align-middle text-center">
                                <span id="selisih_<?php echo e($index); ?>" class="fw-bold">-</span>
                            </td>
                            <td class="align-middle">
                                <input type="text" name="produks[<?php echo e($index); ?>][keterangan]" class="form-control form-control-sm" placeholder="Catatan...">
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; padding: 10px 24px; border-radius: 8px;">
                <i class="fa-solid fa-paper-plane me-1"></i> Submit untuk Persetujuan
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.querySelectorAll('.input-fisik').forEach(input => {
        input.addEventListener('input', function() {
            const index = this.getAttribute('data-index');
            const stokSistem = parseInt(document.getElementById('sistem_' + index).value) || 0;
            const stokFisik = this.value;
            
            const selisihSpan = document.getElementById('selisih_' + index);
            
            if (stokFisik === '') {
                selisihSpan.innerText = '-';
                selisihSpan.className = 'fw-bold';
            } else {
                const selisih = parseInt(stokFisik) - stokSistem;
                selisihSpan.innerText = (selisih > 0 ? '+' : '') + selisih;
                
                if (selisih > 0) {
                    selisihSpan.className = 'fw-bold text-success';
                } else if (selisih < 0) {
                    selisihSpan.className = 'fw-bold text-danger';
                } else {
                    selisihSpan.className = 'fw-bold text-secondary';
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/stok_opname/create.blade.php ENDPATH**/ ?>