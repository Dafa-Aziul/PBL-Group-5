<div class="row card-login d-flex flex-md-row flex-column">
    <!-- Toggle Box -->
    <div class="col-md-6 toggle-box d-flex align-items-center justify-content-center">
        <div>
            <h1><strong>Welcome Back!</strong></h1>
            <p>Silakan login untuk melanjutkan</p>
        </div>
    </div>

    <!-- Form Box -->
    <div class="col-md-6 form-box">
        <form wire:submit="login">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                    placeholder="Email" name="email" value="{{ old('email') }}" autofocus />
                <i class="fas fa-user"></i>
                @error('email')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>
            <div class="input-box">
                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                    wire:model="password" placeholder="Password" id="passwordInput"/>
                <i class="fas fa-eye toggle-password" id="togglePassword" style="cursor: pointer;"></i>
                @error('password')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 small">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe" />
                    <label class="form-check-label" for="rememberMe" wire:model="remember">
                        Ingat saya
                    </label>
                </div>
                <a href="{{ route('password.request') }}" wire:navigate class="text-decoration-none">Forgot
                    Password?</a>
            </div>

            <button type="submit" class="btn btn-custom w-100">Login</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("passwordInput");

    togglePassword.addEventListener("click", function () {
        const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
        passwordInput.setAttribute("type", type);
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
</script>
@endpush

