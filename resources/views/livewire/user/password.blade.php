<div>
    <h2 class="mt-4">Reset Password</h2>
    <ol class="breadcrumb mb-4">
        {{-- <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('user.view') }}">Profile</a></li> --}}
        <li class="breadcrumb-item active">Change your password</li>
    </ol>
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-key"></i>
                <span class="d-none d-md-inline ms-1">Reset Password</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{ route('dashboard') }}" wire:navigate>
                    <i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="updatePassword">
                <div class="mb-3">
                    <label>Password Saat Ini</label>
                    <div class="input-group">
                        <input type="password" class="form-control" wire:model="current_password"
                            id="current_password">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('current_password')">
                            <i class="fas fa-eye" id="current_password_icon"></i>
                        </button>
                    </div>
                    @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" wire:model="password" id="password">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password_icon"></i>
                        </button>
                    </div>
                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" wire:model="password_confirmation"
                            id="password_confirmation">
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation_icon"></i>
                        </button>
                    </div>
                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-success">Ubah Password</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>

</div>
<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }
</script>
