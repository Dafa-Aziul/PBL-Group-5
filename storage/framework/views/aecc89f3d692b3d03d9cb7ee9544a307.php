<?php $__env->startPush('scripts'); ?>
    <script>
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop fade show').forEach(el => el.remove());
    </script>
    <script>
        const myModal = document.getElementById('confirmPassword')
        const myInput = document.getElementById('password_confirmation')

        myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
        })
    </script>
<?php $__env->stopPush(); ?>
<div>
    <h1 class="mt-4">Manajemen User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="<?php echo e(route('user.view')); ?>">User</a></li>
        <li class="breadcrumb-item active">Daftar User</li>
    </ol>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
    <div class="        ">
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    </div
    <?php elseif(session()->has('error')): ?>
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
                <span class="d-none d-md-inline ms-1">Daftar User</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="<?php echo e(route('user.create')); ?>" wire:navigate><i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah User</span>
                </a>
                
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage" style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label for="perPage" class="ms-2 mb-0">Entries per page</label>
                </div>  
            
                <!-- Search Input with Icon -->
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Search" wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div> 
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Verifikasi</th>
                            <th>Tanggal dibuat</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-center"><?php echo e($loop->iteration + ($users->currentPage() - 1) * $users->perPage()); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->role); ?></td>
                                <td><?php echo e($user->email_verified_at ?? "Belum Verifikasi"); ?></td>
                                <td><?php echo e($user->created_at); ?></td>
                                <td><?php echo e($user->updated_at); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-warning" wire:click="edit(<?php echo e($user->id); ?>)"><i class="fa-solid fa-pen-to-square"></i><span class="d-none d-md-inline ms-1">Edit</span></button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm">  <i class="fas fa-trash-can"></i><span class="d-none d-md-inline ms-1">Delete</span></button>
                                    <?php if (isset($component)) { $__componentOriginale9f572557820c4cd5a6bbfd15f332f84 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9f572557820c4cd5a6bbfd15f332f84 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.confirm','data' => ['id' => 'confirm','action' => 'modal','targetModal' => 'confirmPassword','content' => 'Apakah anda yakin untuk menghapus ini?']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.confirm'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'confirm','action' => 'modal','targetModal' => 'confirmPassword','content' => 'Apakah anda yakin untuk menghapus ini?']); ?>
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
                                    <?php if (isset($component)) { $__componentOriginalbb11689f02510ea971d8bee635a722ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb11689f02510ea971d8bee635a722ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.confirmPassword','data' => ['id' => 'confirmPassword','target' => 'delete('.e($user->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.confirmPassword'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'confirmPassword','target' => 'delete('.e($user->id).')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb11689f02510ea971d8bee635a722ad)): ?>
<?php $attributes = $__attributesOriginalbb11689f02510ea971d8bee635a722ad; ?>
<?php unset($__attributesOriginalbb11689f02510ea971d8bee635a722ad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb11689f02510ea971d8bee635a722ad)): ?>
<?php $component = $__componentOriginalbb11689f02510ea971d8bee635a722ad; ?>
<?php unset($__componentOriginalbb11689f02510ea971d8bee635a722ad); ?>
<?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </table>
            </div>
                                 
            <?php echo e($users->links()); ?>

        </div>
    </div>
    
</div>

<?php /**PATH D:\Bengkel Proyek\resources\views/livewire/user/index.blade.php ENDPATH**/ ?>