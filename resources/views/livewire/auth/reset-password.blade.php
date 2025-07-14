<div class="row card-login d-flex flex-md-row flex-column">
    <!-- Kiri: Info Visual -->
    <div class="col-md-6 toggle-box d-flex align-items-center justify-content-center">
        <div class="text-center">
            <h1><strong>Atur Ulang Sandi</strong></h1>
            <p>Masukkan sandi baru untuk akunmu.</p>
        </div>
    </div>

    <!-- Kanan: Form -->
    <div class="col-md-6 form-box">
        <form wire:submit.prevent="resetPassword">
            <h1>Reset Password</h1>

            <div class="input-box">
                <input type="email" id="resetEmail" class="form-control @error('email') is-invalid @enderror"
                    wire:model="email" placeholder="Email" readonly>
                <i class="fa-solid fa-envelope"></i>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <input type="password" id="passwordInput" class="form-control @error('password') is-invalid @enderror"
                    wire:model="password" placeholder="Kata Sandi Baru">
                <i class="fa-solid fa-eye toggle-password" data-target="passwordInput" style="top: 50%; right: 16px; transform: translateY(-50%); cursor: pointer; position: absolute;"></i>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <input type="password" id="confirmInput" class="form-control @error('password_confirmation') is-invalid @enderror"
                    wire:model="password_confirmation" placeholder="Konfirmasi Sandi">
                <i class="fa-solid fa-eye toggle-password" data-target="confirmInput" style="top: 50%; right: 16px; transform: translateY(-50%); cursor: pointer; position: absolute;"></i>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-custom w-100" type="submit">Atur Ulang</button>

            <div class="mt-3 text-center">
                <a href="{{ route('login') }}" class="small text-decoration-none" wire:navigate>← Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', () => {
            const targetId = icon.dataset.target;
            const input = document.getElementById(targetId);
            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
        });
    });
</script>
@endpush

