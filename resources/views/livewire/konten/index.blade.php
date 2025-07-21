<div>
    <h2 class="mt-4">Kelola Konten</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('konten.view') }}">Manajemen Konten</a></li>
        <li class="breadcrumb-item active">Daftar Konten</li>
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
                <span class="ms-1">Daftar Konten</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('konten.create') }}" wire:navigate>
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah Konten</span>
                </a>
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
                            <th>Judul Konten</th>
                            <th>Kategori</th>
                            <th>Isi</th>
                            <th>Penulis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kontens as $konten)
                        <tr class="align-middle">
                            <td class="text-center">{{ ($kontens->firstItem() +$loop->iteration) - 1 }}</td>
                            <td>{{ $konten->judul }}</td>
                            <td>{{ $konten->kategori }}</td>
                            <td>{!! $konten->isi !!}</td>
                            <td>{{ $konten->penulis->nama}}</td>
                            <td class="text-center">
                                @php
                                $status = strtolower($konten->status);
                                $badgeClass = match($status) {
                                'draft' => 'bg-secondary',
                                'terbit' => 'bg-success',
                                'arsip' => 'bg-warning text-dark',
                                default => 'bg-light text-dark',
                                };
                                @endphp

                                <span class="badge {{ $badgeClass }} px-3 py-1 fw-semibold">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>


                            <td class="text-center">
                                <a href="{{ route('konten.edit', ['id' => $konten->id]) }}"
                                    class="btn btn-warning btn-sm me-1 mb-2 mb-md-2" wire:navigate>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>
                                <button class="btn btn-danger btn-sm me-1 mb-2 mb-md-2" data-bs-toggle="modal"
                                    data-bs-target="#confirm-{{ $konten->id }}">
                                    <i class="fas fa-trash-can"></i>
                                    <span class="d-none d-md-inline ms-1">Delete</span>
                                </button>

                                <x-modal.confirm id="confirm-{{ $konten->id }}" action="" target="delete({{ $konten->id }})"
                                    content="Apakah anda yakin untuk menghapus data ini?" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse
                </table>
                {{ $kontens->links() }}
            </div>
        </div>
    </div>
</div>
