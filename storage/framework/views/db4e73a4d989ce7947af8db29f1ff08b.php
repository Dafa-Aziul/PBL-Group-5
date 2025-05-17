<?php $__env->startPush('scripts'); ?>
    <script>
        livewire.on('modal:close', () => {
            $('#confirmPassword').modal('hide');
        });
    </script>
<?php $__env->stopPush(); ?>
<div>
    <h1 class="mt-4">Manajemen User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="<?php echo e(route('user.view')); ?>">User</a></li>      
        <li class="breadcrumb-item active">Tambah User</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data User</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="<?php echo e(route('user.view')); ?>" wire:navigate><i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="validateInput">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" class="form-control" wire:model="form.name">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" wire:model="form.email">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select class="form-select" wire:model="form.role">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="mekanik">Mekanik</option>
                        <option value="owner">Owner</option>
                    </select>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" wire:model="form.password">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['form.password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmPassword">Simpan</button>
            <button wire:click='resetForm' type="reset" class="btn btn-warning">Reset</button>
        </form>
        <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
            <?php if (isset($component)) { $__componentOriginalbb11689f02510ea971d8bee635a722ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb11689f02510ea971d8bee635a722ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.confirmPassword','data' => ['id' => 'confirmPassword','target' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.confirmPassword'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'confirmPassword','target' => 'submit']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb11689f02510ea971d8bee635a722ad)): ?>
<?php $attributes = $__attributesOriginalbb11689f02510ea971d8bee635a722ad; ?>
<?php unset($__attributesOriginalbb11689f02510ea971d8bee635a722ad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb11689f02510ea971d8bee635a722ad)): ?>
<?php $component = $__componentOriginalbb11689f02510ea971d8bee635a722ad; ?>
<?php unset($__componentOriginalbb11689f02510ea971d8bee635a722ad); ?>
<?php endif; ?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->            
        </div>
    </div>
</div>

<?php /**PATH D:\Bengkel Proyek\resources\views/livewire/user/create.blade.php ENDPATH**/ ?>