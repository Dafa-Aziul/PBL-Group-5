<div>
    <h1 class="mt-4">Kelola Jenis Kendaraan</h1>
    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="<?php echo e(route('jenis_kendaraan.view')); ?>">Jenis Kendaraan</a></li>

        <li class="breadcrumb-item active">Tambah Jenis Kendaraan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Edit Data Kendaraan</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="<?php echo e(route('jenis_kendaraan.view')); ?>" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="mb-3">
                    <label>Nama Jenis</label>

                    <input type="text" class="form-control" wire:model="form.nama_jenis"  value="<?php echo e(old('form.nama_jenis', $jenis_kendaraan->nama_jenis)); ?>" >

                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.nama_jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="mb-3">
                    <label>Tipe Kendaraan</label>
                    <input type="text" class="form-control" wire:model="form.tipe_kendaraan" value="<?php echo e(old('form.tipe_kendaraan', $jenis_kendaraan->tipe_kendaraan)); ?>">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.tipe_kendaraan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" wire:model="form.deskripsi" value="<?php echo e(old('form.deskripsi', $jenis_kendaraan->deskripsi)); ?>">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>


                <button type="submit" class="btn btn-success" >Simpan</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>
</div><?php /**PATH D:\Bengkel Proyek\resources\views/livewire/jenis-kendaraan/edit.blade.php ENDPATH**/ ?>