<?php $__env->startSection('title', 'Jadwal Shift Kerja'); ?>

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



<?php if(auth()->user()->role === 'super'): ?>
<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body">
        <form action="<?php echo e(route('jadwal_shift.index')); ?>" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size: 13px;">Filter Cabang</label>
                <select name="id_cabang" class="form-select" style="border-radius: 6px; border: 1px solid #d1d5db; padding: 6px 12px; font-size: 13.5px;">
                    <option value="">Semua Cabang</option>
                    <?php $__currentLoopData = \App\Models\Cabang::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cabang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($cabang->id_cabang); ?>" <?php echo e(request('id_cabang') == $cabang->id_cabang ? 'selected' : ''); ?>><?php echo e($cabang->nama_cabang); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary" style="background-color: #1a5ca6; border-color: #1a5ca6; border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Terapkan Filter</button>
                <?php if(request()->has('id_cabang') && request('id_cabang') != ''): ?>
                    <a href="<?php echo e(route('jadwal_shift.index')); ?>" class="btn btn-outline-secondary" style="border-radius: 6px; font-weight: 500; padding: 6px 14px; font-size: 13.5px;">Reset</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0 rounded-3">
    <div class="table-responsive">
        <table class="table mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 60px;">NO</th>

                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">KARYAWAN</th>
                    <?php if(auth()->user()->role === 'super'): ?>
                        <th class="py-3 px-4 text-muted" style="font-size: 12px;">CABANG</th>
                    <?php endif; ?>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px;">SHIFT</th>

                    <?php if(auth()->user()->role === 'admin cabang'): ?>
                    <th class="py-3 px-4 text-muted" style="font-size: 12px; width: 100px;">AKSI</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if(auth()->user()->role === 'admin cabang'): ?>
                    <?php $__empty_1 = true; $__currentLoopData = $karyawanSchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 text-muted"><?php echo e($index + 1); ?></td>

                            <td class="px-4">
                                <span class="fw-bold text-dark"><?php echo e($item->karyawan->name); ?></span><br>
                                <small class="text-muted"><?php echo e($item->karyawan->email); ?></small>
                            </td>
                            <td class="px-4">
                                <?php if($item->jadwal): ?>
                                    <span class="fw-bold text-primary"><?php echo e($item->jadwal->masterShift->nama_shift ?? 'Shift Dihapus'); ?></span>

                                    <?php if($item->jadwal->keterangan): ?>
                                        <div class="text-muted mt-1" style="font-size: 11px;"><i class="fa-regular fa-comment-dots me-1"></i> <?php echo e($item->jadwal->keterangan); ?></div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="px-4">
                                <?php if($item->jadwal): ?>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary" title="Edit Jadwal" onclick="tugaskanKaryawan(<?php echo e($item->karyawan->id_user); ?>)" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-jadwal" 
                                            title="Batalkan Jadwal"
                                            data-id="<?php echo e($item->jadwal->id_jadwal_shift); ?>"
                                            data-nama="<?php echo e($item->karyawan->name); ?>">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-primary" style="background-color: #1a5ca6; font-size: 11px; border-radius: 6px; font-weight: 500;" onclick="tugaskanKaryawan(<?php echo e($item->karyawan->id_user); ?>)" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                        <i class="fa-solid fa-calendar-plus me-1"></i> Jadwalkan
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada data karyawan di cabang ini.</td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <?php $__empty_1 = true; $__currentLoopData = $jadwalShifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $jadwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 text-muted"><?php echo e($jadwalShifts->firstItem() + $index); ?></td>

                            <td class="px-4">
                                <span class="fw-bold text-dark"><?php echo e($jadwal->user->name ?? 'User Dihapus'); ?></span>
                            </td>
                            <?php if(auth()->user()->role === 'super'): ?>
                                <td class="px-4 text-primary"><?php echo e($jadwal->cabang->nama_cabang); ?></td>
                            <?php endif; ?>
                            <td class="px-4">
                                <span class="fw-bold text-primary"><?php echo e($jadwal->masterShift->nama_shift ?? 'Shift Dihapus'); ?></span>

                                </td>

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="<?php echo e(auth()->user()->role === 'super' ? '7' : '6'); ?>" class="text-center py-4 text-muted">Belum ada jadwal shift.</td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if(auth()->user()->role === 'super' && $jadwalShifts->hasPages()): ?>
        <div class="card-footer bg-white border-top py-3 px-4">
            <?php echo e($jadwalShifts->links('pagination::bootstrap-5')); ?>

        </div>
    <?php endif; ?>
</div>

<?php if(auth()->user()->role === 'admin cabang'): ?>
<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <form action="<?php echo e(route('jadwal_shift.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Tugaskan Jadwal Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="tanggal" id="inputTanggalMulai" value="<?php echo e($tanggal); ?>">
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Karyawan</label>
                        <select name="id_user" id="selectKaryawan" class="form-select" required>
                            <option value="">-- Pilih Karyawan --</option>
                            <?php $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($k->id_user); ?>"><?php echo e($k->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium text-muted" style="font-size: 13px;">Pilih Master Shift</label>
                        <select name="id_master_shift" class="form-select" required>
                            <option value="">-- Pilih Jam Kerja --</option>
                            <?php $__currentLoopData = $masterShifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($ms->id_master_shift); ?>"><?php echo e($ms->nama_shift); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
</div>

<!-- Modal Hapus Jadwal -->
<div class="modal fade" id="modalHapusJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <i class="fa-solid fa-triangle-exclamation text-danger" style="font-size: 40px;"></i>
                </div>
                <h5 class="fw-bold mb-2">Hapus Jadwal Shift?</h5>
                <p class="text-muted" style="font-size: 13px; margin-bottom: 0;">Apakah Anda yakin ingin membatalkan jadwal shift untuk <strong id="deleteNamaKaryawan"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0 pb-4">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Batal</button>
                <form id="formDeleteJadwal" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger" style="border-radius: 8px; font-weight: 500;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>

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

<?php $__env->startSection('scripts'); ?>
<script>
    function tugaskanKaryawan(idUser) {
        document.getElementById('selectKaryawan').value = idUser;
        document.getElementById('inputTanggalMulai').value = "<?php echo e($tanggal); ?>";
    }

    document.querySelectorAll('.btn-delete-jadwal').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            
            document.getElementById('deleteNamaKaryawan').innerText = nama;
            
            const formDelete = document.getElementById('formDeleteJadwal');
            formDelete.action = "<?php echo e(url('/jadwal_shift')); ?>/" + id;
            
            const modalHapus = new bootstrap.Modal(document.getElementById('modalHapusJadwal'));
            modalHapus.show();
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Semester_6\TUGAS AKHIR NGODING\sistem-penjualan-rsix-cell\resources\views/admin/jadwal_shift/index.blade.php ENDPATH**/ ?>