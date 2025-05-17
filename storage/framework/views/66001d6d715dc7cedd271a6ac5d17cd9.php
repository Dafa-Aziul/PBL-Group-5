<div>
    <h1 class="mt-4">Kelola Jenis Kendaraan</h1>
    <ol class="breadcrumb mb-4">

        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="<?php echo e(route('jenis_kendaraan.view')); ?>">Jenis Kendaraan</a></li>

        <li class="breadcrumb-item active">Daftar Jenis Kendaraan</li>
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
                <span class="d-none d-md-inline ms-1">Daftar Jenis Kendaraan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="<?php echo e(route('jenis_kendaraan.create')); ?>" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah kendaraan</span>
                </a>

            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage"

                        style="width:auto;cursor:pointer;">

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

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Jenis</th>
                            <th>Tipe Kendaraan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $jenis_kendaraans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($jenis->nama_jenis); ?></td>
                            <td><?php echo e($jenis->tipe_kendaraan); ?></td>
                            <td><?php echo e($jenis->deskripsi); ?></td>
                            <td class="text-center">

                                    <a href="<?php echo e(route('jenis_kendaraan.edit', ['id' => $jenis->id])); ?>"
                                        class="btn btn-warning" wire:navigate>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </a>

                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm"> <i
                                        class="fas fa-trash-can"></i><span
                                        class="d-none d-md-inline ms-1">Delete</span></button>
                                <?php if (isset($component)) { $__componentOriginale9f572557820c4cd5a6bbfd15f332f84 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9f572557820c4cd5a6bbfd15f332f84 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.confirm','data' => ['id' => 'confirm','action' => 'modal','target' => 'delete('.e($jenis->id).')','content' => 'Apakah anda yakin untuk menghapus data ini?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'confirm','action' => 'modal','target' => 'delete('.e($jenis->id).')','content' => 'Apakah anda yakin untuk menghapus data ini?']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale9f572557820c4cd5a6bbfd15f332f84)): ?>
<?php $attributes = $__attributesOriginale9f572557820c4cd5a6bbfd15f332f84; ?>
<?php unset($__attributesOriginale9f572557820c4cd5a6bbfd15f332f84); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale9f572557820c4cd5a6bbfd15f332f84)): ?>
<?php $component = $__componentOriginale9f572557820c4cd5a6bbfd15f332f84; ?>
<?php unset($__componentOriginale9f572557820c4cd5a6bbfd15f332f84); ?>
<?php endif; ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </table>
                <?php echo e($jenis_kendaraans -> links()); ?>

            </div>

        </div>
    </div>

</div><?php /**PATH D:\Bengkel Proyek\resources\views/livewire/jenis-kendaraan/index.blade.php ENDPATH**/ ?>