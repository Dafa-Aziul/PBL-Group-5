@push('scripts')
<script>
    window.addEventListener('closeConfirmPasswordModal', event => {
        const id = event.detail; // dapatkan id dari event detail
        const modalEl = document.getElementById(`confirmPassword-${id}`);
        const modal = bootstrap.Modal.getInstance(modalEl);

        if (modal) {
            modal.hide();
        }

        // Bersihkan backdrop dan class modal-open agar tidak tertinggal
        setTimeout(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        }, 300); // delay kecil supaya transisi modal selesai
    });

    // Jika pakai Livewire, hook untuk cleanup setelah Livewire proses update
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
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('user.view') }}">User</a></li>
        <li class="breadcrumb-item active">Daftar User</li>
    </ol>
    @if (session()->has('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session()->has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif



    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="ms-1">Daftar User</span>
            </div>
            <div>
                @can('admin')
                    <a class="btn btn-primary float-end" href="{{ route('user.create') }}" wire:navigate><i
                            class="fas fa-plus"></i>
                        <span class="d-none d-md-inline ms-1">Tambah User</span>
                    </a>
                @endcan

            </div>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3 align-items-center">
                <!-- Select Entries per page -->
                <div class="col-auto d-flex align-items-center">
                    <select class="form-select form-select" wire:model.live="perPage"
                        style="width:auto; cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label class="d-none d-md-inline ms-2 mb-0 text-muted">Entries per page</label>
                </div>

                <!-- Search -->
                <div class="col-6 ms-auto col-md-4">
                    <div class="position-relative">
                        <input type="text" class="form-control form-control ps-5" placeholder="Search"
                            wire:model.live.debounce.300ms="search" />
                        <i
                            class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Verifikasi</th>
                            <th>Tanggal dibuat</th>
                            <th>Tanggal Update</th>
                            @can('admin')
                            <th>Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="text-center">{{ ($users->firstItem() + $loop->iteration) - 1}}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>{{ $user->email_verified_at ?? "Belum Verifikasi" }}</td>
                            <td>{{ $user->created_at}}</td>
                            <td>{{ $user->updated_at }}</td>
                            @can('admin')
                                <td class="text-center">
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirm-{{ $user->id }}">
                                        <i class="fas fa-trash-can"></i>
                                        <span class="d-none d-md-inline ms-1">Delete</span>
                                    </button>
                                    <x-modal.confirm id="confirm-{{ $user->id }}" action="modal"
                                        targetModal="confirmPassword-{{ $user->id }}" target=""
                                        content="Apakah anda yakin untuk menghapus ini?" />
                                    <x-modal.confirmPassword id="confirmPassword-{{ $user->id }}"
                                        target="delete({{ $user->id }})" action="modal" />
                                </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>

</div>
