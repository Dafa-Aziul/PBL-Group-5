<div>
    <h2 class="mt-4">Kelola Jenis Kendaraan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('jenis_kendaraan.view') }}">Jenis Kendaraan</a></li>
        <li class="breadcrumb-item active">Daftar Jenis Kendaraan</li>
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
                <span class=" ms-1">Daftar Jenis Kendaraan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('jenis_kendaraan.create') }}" wire:navigate>
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah jenis kendaraan</span>
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
                            <th>Nama Jenis</th>
                            <th>Tipe Kendaraan</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        @forelse ($jenis_kendaraans as $jenis)
                        <tr>
                            <td class="text-center">{{ ($jenis_kendaraans->firstItem() +$loop->iteration) - 1 }}</td>
                            <td>{{ $jenis->nama_jenis }}</td>
                            <td>{{ $jenis->tipe_kendaraan }}</td>
                            <td>{{ $jenis->deskripsi }}</td>
                            <td class="text-center">
                                <a href="{{ route('jenis_kendaraan.edit', ['id' => $jenis->id]) }}"
                                    class="btn btn-warning mb-3 mb-md-1" wire:navigate>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>
                                <button class="btn btn-danger mb-3 mb-md-1" data-bs-toggle="modal"
                                    data-bs-target="#confirm"> <i class="fas fa-trash-can"></i><span
                                        class="d-none d-md-inline ms-1">Delete</span></button>
                                <x-modal.confirm id="confirm" action="modal" target="delete({{ $jenis->id }})"
                                    content="Apakah anda yakin untuk menghapus data ini?" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse
                </table>
                {{ $jenis_kendaraans -> links() }}
            </div>
        </div>
    </div>

</div>
