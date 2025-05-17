<div class="container-fluid ">
    <main class="card shadow-lg p-4 rounded-4 position-absolute top-50 start-50 translate-middle" style="width: 100%; max-width: 420px;">
        <form wire:submit="login" class="form-signin">
        <div class="text-center mb-4">
            <i class="fa-solid fa-circle-user fs-1 text-primary mb-4" ></i>
            <h1 class="h4 fw-bold">Login ke Akun Anda</h1>
            <p class="text-muted small">Masukkan email dan password untuk melanjutkan</p>
        </div>
    
        <div class="form-floating mb-3">
            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="email" id="floatingInput" placeholder="name@example.com" name="email" value="<?php echo e(old('email')); ?>"  autofocus>
            <label for="floatingInput">Alamat Email</label>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="invalid-feedback"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    
        <div class="form-floating mb-3">
            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="password" id="floatingPassword" placeholder="Password" name="password" >
            <label for="floatingPassword">Kata Sandi</label>
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="invalid-feedback"><?php echo e($message); ?></small>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div>
            <!--[if BLOCK]><![endif]--><?php if(session('gagal')): ?>
            <p class="text-danger">*<?php echo e(session('gagal')); ?></p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div class="form-check mb-3 d-flex align-items-center justify-content-between">
            <div>
                <input class="form-check-input" type="checkbox" value=True id="rememberMe" wire:model="remember">
                <label class="form-check-label" for="rememberMe">
                Ingat saya
                </label>
            </div>
            <div>
                <a class="small" href="<?php echo e(route('password.request')); ?>" wire:navigate>Forgot Password?</a>
            </div>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
        </form>
    </main>
</div> <?php /**PATH D:\Bengkel Proyek\resources\views/livewire/auth/login.blade.php ENDPATH**/ ?>