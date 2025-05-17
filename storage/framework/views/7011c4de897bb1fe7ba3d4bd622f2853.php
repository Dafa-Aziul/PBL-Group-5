<div>
    <h1 class="mt-4">Kelola Jenis Jasa</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="<?php echo e(route('jasa.view')); ?>">Jenis Kendaraan</a></li>
        <li class="breadcrumb-item active">Daftar Jenis Jasa Service</li>
    </ol>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
    <div class="        ">
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    </div <?php elseif(session()->has('error')): ?>
    <div class="">
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Daftar jenis jasa</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="<?php echo e(route('jasa.create')); ?>" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah jenis jasa</span>
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
                            <th>Kode</th>
                            <th>Nama Jasa</th>
                            <th>Jenis Kendaraan</th>
                            <th>Estimasi</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $jasas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jasa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="text-center"><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($jasa->kode); ?></td>
                            <td><?php echo e($jasa->nama_jasa); ?></td>
                            <td><?php echo e($jasa->jenisKendaraan->nama_jenis ?? '-'); ?></td>
                            <td>
                                <?php
                                [$jam, $menit] = explode(':', $jasa->estimasi);
                                ?>
                                <?php echo e((int) $jam); ?> jam <?php echo e((int) $menit); ?> menit
                            </td>

                            <td>Rp <?php echo e(number_format($jasa->harga, 0, ',', '.')); ?></td>
                            <td><?php echo e($jasa->keterangan); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e(route('jasa.edit', ['id' => $jasa->id])); ?>" class="btn btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm"> <i
                                        class="fas fa-trash-can"></i><span
                                        class="d-none d-md-inline ms-1">Delete</span></button>
                                <?php if (isset($component)) { $__componentOriginale9f572557820c4cd5a6bbfd15f332f84 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9f572557820c4cd5a6bbfd15f332f84 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.confirm','data' => ['id' => 'confirm','action' => 'modal','target' => 'delete('.e($jasa->id).')','content' => 'Apakah anda yakin untuk menghapus data ini?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'confirm','action' => 'modal','target' => 'delete('.e($jasa->id).')','content' => 'Apakah anda yakin untuk menghapus data ini?']); ?>
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
                            <td colspan="8" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </table>
            </div>

            <?php echo e($jasas->links()); ?>

        </div>
    </div>

</div><?php /**PATH D:\Bengkel Proyek\resources\views/livewire/jasa/index.blade.php ENDPATH**/ ?>