<div class="container-fluid">
    <main class="card shadow-lg p-4 rounded-4 position-absolute top-50 start-50 translate-middle" style="width: 100%; max-width: 420px;">
        <form wire:submit="resetPassword" class="form-signin">
            <div class="text-center mb-4">
                <i class="fa-solid fa-lock fs-1 text-primary mb-4"></i>
                <h1 class="h4 fw-bold">Atur Ulang Kata Sandi</h1>
                <p class="text-muted small">Masukkan kata sandi baru untuk akun Anda.</p>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" id="resetEmail" placeholder="name@example.com" readonly>
                <label for="resetEmail">Alamat Email</label>
                @error('email')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" id="resetPassword" placeholder="Password Baru">
                <label for="resetPassword">Kata Sandi Baru</label>
                @error('password')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model="password_confirmation" id="resetConfirm" placeholder="Konfirmasi Password">
                <label for="resetConfirm">Konfirmasi Kata Sandi</label>
                @error('password_confirmation')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Atur Ulang</button>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}" class="small text-decoration-none" wire:navigate>← Kembali ke Login</a>
            </div>
        </form>
    </main>
</div>
