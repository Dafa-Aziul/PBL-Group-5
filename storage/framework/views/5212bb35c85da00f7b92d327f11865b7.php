<div>
    <h1 class="mt-4">Kelola Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="<?php echo e(route('pelanggan.view')); ?>">Pelanggan</a></li>
        <li class="breadcrumb-item active">Daftar Pelanggan</li>
    </ol>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
    <div class="        ">
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    </div <?php elseif(session()->has('error')): ?>
    <div class="        ">
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Daftar Pelanggan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="<?php echo e(route('pelanggan.create')); ?>" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah Pelanggan</span>
                </a>

            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage"
                        style="width:auto;cursor:pointer;" >
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label for="perPage" class="d-none d-md-inline ms-2 mb-0">Entries per page</label>
                </div>

                <!-- Search Input with Icon -->
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Search"
                        wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>

            <div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        </tfoot>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $pelanggans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelanggan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="cursor:pointer;"  x-data @click="Livewire.navigate(`/pelanggan/<?php echo e($pelanggan->id); ?>`)">
                                <td class="text-center"><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($pelanggan->nama); ?></td>
                                <td><?php echo e($pelanggan->email); ?></td>
                                <td><?php echo e($pelanggan->no_hp); ?></td>
                                <td><?php echo e($pelanggan->alamat); ?></td>
                                <td><?php echo e($pelanggan->keterangan); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('pelanggan.edit', ['id' => $pelanggan->id])); ?> " class="btn btn-warning" wire:navigate @click.stop>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </table>
                    <?php echo e($pelanggans -> links()); ?>

                </div>
            </div>
        </div>
    </div>

</div><?php /**PATH D:\Bengkel Proyek\resources\views/livewire/pelanggan/index.blade.php ENDPATH**/ ?>