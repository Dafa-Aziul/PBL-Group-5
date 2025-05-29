<div class="container-fluid ">
    <main class="card shadow-lg p-4 rounded-4 position-absolute top-50 start-50 translate-middle"
        style="width: 100%; max-width: 420px;">
        <form wire:submit="login" class="form-signin">
            <div class="text-center mb-4">
                <i class="fa-solid fa-circle-user fs-1 text-primary mb-4"></i>
                <h1 class="h4 fw-bold">Login ke Akun Anda</h1>
                <p class="text-muted small">Masukkan email dan password untuk melanjutkan</p>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                    id="floatingInput" placeholder="name@example.com" name="email" value="{{ old('email') }}" autofocus>
                <label for="floatingInput">Alamat Email</label>
                @error('email')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    wire:model="password" id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Kata Sandi</label>
                @error('password')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>
            <div>
                @if(session('gagal'))
                <p class="text-danger">*{{ session('gagal') }}</p>
                @endif
            </div>
            <div class="form-check mb-3 d-flex align-items-center justify-content-between">
                <div>
                    <input class="form-check-input" type="checkbox" value=True id="rememberMe" wire:model="remember">
                    <label class="form-check-label" for="rememberMe">
                        Ingat saya
                    </label>
                </div>
                <div>
                    <a class="small" href="{{ route('password.request') }}" wire:navigate>Forgot Password?</a>
                </div>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
        </form>

    </main>
</div>
