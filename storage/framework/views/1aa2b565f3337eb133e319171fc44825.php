<div>
    <h1 class="mt-4">Kelola Karyawan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="<?php echo e(route('user.view')); ?>">Karyawan</a></li>
        <li class="breadcrumb-item active">Daftar Karyawan</li>
    </ol>

    
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php elseif(session()->has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Daftar Karyawan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="<?php echo e(route('karyawan.create')); ?>" wire:navigate>
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah karyawan</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage" style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label for="perPage" class="ms-2 mb-0">Entri per halaman</label>
                </div>

                
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Cari" wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>No Hp</th>
                            <th>Alamat</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $karyawans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $karyawan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                
                                <td class="text-center"><?php echo e($karyawans->firstItem() + $loop->index); ?></td>
                                <td><?php echo e($karyawan->user->name); ?></td>
                                <td><?php echo e($karyawan->jabatan); ?></td>
                                <td><?php echo e($karyawan->no_hp); ?></td>
                                <td><?php echo e($karyawan->alamat); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($karyawan->tgl_masuk)->format('d-m-Y')); ?></td>
                                <td class="text-center">
                                    <!--[if BLOCK]><![endif]--><?php if($karyawan->status === 'aktif'): ?>
                                        <span class="btn btn-success btn-sm">Aktif</span>
                                    <?php else: ?>
                                        <span class="btn btn-secondary btn-sm">Tidak Aktif</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="text-center">
                                    <!--[if BLOCK]><![endif]--><?php if($karyawan->foto): ?>
                                        <img src="<?php echo e(asset('storage/' . $karyawan->foto)); ?>" alt="Foto Karyawan" width="50" height="50" class="rounded-circle">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="<?php echo e(route('karyawan.edit', ['id' => $karyawan->id])); ?>" class="btn btn-warning btn-sm me-1">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span class="d-none d-md-inline ms-1">Edit</span>
                                        </a>

                                        
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirm-<?php echo e($karyawan->id); ?>">
                                            <i class="fas fa-trash-can"></i>
                                            <span class="d-none d-md-inline ms-1">Delete</span>
                                        </button>
                                        <?php if (isset($component)) { $__componentOriginale9f572557820c4cd5a6bbfd15f332f84 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9f572557820c4cd5a6bbfd15f332f84 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.confirm','data' => ['id' => 'confirm-'.e($karyawan->id).'','action' => 'modal','target' => 'delete('.e($karyawan->id).')','content' => 'Apakah anda yakin untuk menghapus karyawan ini?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'confirm-'.e($karyawan->id).'','action' => 'modal','target' => 'delete('.e($karyawan->id).')','content' => 'Apakah anda yakin untuk menghapus karyawan ini?']); ?>
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
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                
                                <td colspan="9" class="text-center text-muted">Tidak ada data karyawan yang ditemukan.</td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
                <?php echo e($karyawans->links()); ?>

            </div>
        </div>
    </div>
</div><?php /**PATH D:\Bengkel Proyek\resources\views/livewire/karyawan/index.blade.php ENDPATH**/ ?>