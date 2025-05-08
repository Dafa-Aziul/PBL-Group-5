<div class="container-fluid">
    <main class="card shadow-lg p-4 rounded-4 position-absolute top-50 start-50 translate-middle" style="width: 100%; max-width: 420px;">
        <form wire:submit="sendPasswordResetLink" class="form-signin">
            <div class="text-center mb-4">
                <i class="fa-solid fa-envelope-circle-check fs-1 text-primary mb-4"></i>
                <h1 class="h4 fw-bold">Lupa Kata Sandi?</h1>
                <p class="text-muted small">Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang kata sandi.</p>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" id="floatingEmail" placeholder="name@example.com" autofocus>
                <label for="floatingEmail">Alamat Email</label>
                @error('email')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            @if (session('status'))
                <div class="alert alert-success small">
                    {{ session('status') }}
                </div>
            @endif
            
            <button class="btn btn-primary w-100 py-2" type="submit">Kirim Link Reset</button>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}" class="small text-decoration-none" wire:navigate>← Kembali ke Login</a>
            </div>
        </form>
    </main>
</div>
