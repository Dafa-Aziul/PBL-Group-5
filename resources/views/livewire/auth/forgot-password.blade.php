{{-- <div class="container-fluid">
    <main class="card shadow-lg p-4 rounded-4 position-absolute top-50 start-50 translate-middle"
        style="width: 100%; max-width: 420px;">
        <form wire:submit="sendPasswordResetLink" class="form-signin">
            <div class="text-center mb-4">
                <i class="fa-solid fa-envelope-circle-check fs-1 text-primary mb-4"></i>
                <h1 class="h4 fw-bold">Lupa Kata Sandi?</h1>
                <p class="text-muted small">Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang kata
                    sandi.</p>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                    id="floatingEmail" placeholder="name@example.com" autofocus>
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
</div> --}}
<div class="row card-login d-flex flex-md-row flex-column">
    <!-- Left Side (Visual/Info) -->
    <div class="col-md-6 toggle-box d-flex align-items-center justify-content-center">
        <div class="px-4 text-center" style="max-width: 360px;">
            <h1><strong>Lupa Kata Sandi?</strong></h1>
            <p>Kami akan bantu kamu mengatur ulang kata sandi.</p>
        </div>
    </div>

    <!-- Right Side (Form) -->
    <div class="col-md-6 form-box">
        <form wire:submit="sendPasswordResetLink" class="form-signin">
            <h1>Reset Password</h1>

            <div class="input-box">
                <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                    placeholder="Alamat Email" autofocus />
                <i class="fas fa-envelope"></i>
                @error('email')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            @if (session('status'))
            <div class="alert alert-success small mt-2">
                {{ session('status') }}
            </div>
            @endif

            <button type="submit" class="btn btn-custom w-100">Kirim Link Reset</button>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}" class="small text-decoration-none" wire:navigate>← Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>
