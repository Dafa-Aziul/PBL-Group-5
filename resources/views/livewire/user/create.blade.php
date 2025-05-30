@push('scripts')
<script>
    // Menangani pemanggilan modal
    window.addEventListener('open-confirm-password-modal', event => {
        const modalEl = document.getElementById('confirmPassword');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });

    // Menangani penutupan modal
    window.addEventListener('hide-confirm-password-modal', event => {
        const modalEl = document.getElementById('confirmPassword');
        const modal = bootstrap.Modal.getInstance(modalEl);

        if (modal) {
            modal.hide();
        }

        // Tambahan: bersihkan backdrop jika tertinggal
        setTimeout(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        }, 300); // delay kecil untuk pastikan transisi selesai
    });

    // Opsional: Jika pakai Livewire, tambahkan hook
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', () => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        });
    });
</script>
@endpush
<div>
    <h2 class="mt-4">Manajemen User</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="{{ route('user.view') }}">User</a></li>
        <li class="breadcrumb-item active">Tambah User</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data User</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('user.view') }}" wire:navigate><i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="validateInput">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" class="form-control" wire:model="form.name">
                    @error('form.name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" wire:model="form.email">
                    @error('form.email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select class="form-select" wire:model="form.role">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="mekanik">Mekanik</option>
                        <option value="owner">Owner</option>
                    </select>
                    @error('form.role') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" wire:model="form.password">
                    @error('form.password') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            <button type="submit" class="btn btn-success" >Simpan</button>
            <button wire:click='resetForm' type="reset" class="btn btn-warning">Reset</button>
        </form>
            <x-modal.confirmPassword id="confirmPassword" target="submit"></x-modal.confirmPassword>
        </div>
    </div>
</div>

