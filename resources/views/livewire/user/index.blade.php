@push('scripts')
    <script>
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop fade show').forEach(el => el.remove());
    </script>
    <script>
        const myModal = document.getElementById('confirmPassword')
        const myInput = document.getElementById('password_confirmation')

        myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
        })
    </script>
@endpush
<div>
    <h1 class="mt-4">Manajemen User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('user.view') }}">User</a></li>
        <li class="breadcrumb-item active">Daftar User</li>
    </ol>
    @if (session()->has('success'))
    <div class="        ">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div
    @elseif (session()->has('error'))
        <div class="        ">
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        </div>
    @endif


    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Daftar User</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('user.create') }}" wire:navigate><i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah User</span>
                </a>
                
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage" style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label for="perPage" class="ms-2 mb-0">Entries per page</label>
                </div>  
            
                <!-- Search Input with Icon -->
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Search" wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->email_verified_at ?? "Belum Verifikasi" }}</td>
                                <td>{{ $user->created_at}}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning" wire:click="edit({{ $user->id }})"><i class="fa-solid fa-pen-to-square"></i><span class="d-none d-md-inline ms-1">Edit</span></button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm">  <i class="fas fa-trash-can"></i><span class="d-none d-md-inline ms-1">Delete</span></button>
                                    <x-modal.confirm id="confirm" action="modal" targetModal="confirmPassword" content="Apakah anda yakin untuk menghapus ini?" />
                                    <x-modal.confirmPassword id="confirmPassword" target="delete({{ $user->id }})" />
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                        @endforelse
                </table>
            </div>     
            {{ $users->links() }}
        </div>
    </div>
    
</div>

