<div>
    <h1 class="mt-4">Kelola Jenis Kendaraan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="{{ route('jenis_kendaraan.view') }}">Jenis Kendaraan</a></li>
        <li class="breadcrumb-item active">Daftar Jenis Kendaraan</li>
    </ol>
    @if (session()->has('success'))
    <div class="        ">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div @elseif (session()->has('error'))
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
                <span class="d-none d-md-inline ms-1">Daftar Jenis Kendaraan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('jenis_kendaraan.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah kendaraan</span>
                </a>

            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage"
                        style="width:auto;cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label for="perPage" class="d-none d-md-inline ms-2 mb-0">Entries per page</label>
                </div>

                <!-- Search Input with Icon -->
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Search"
                        wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
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
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $jenis->nama_jenis }}</td>
                            <td>{{ $jenis->model_kendaraan }}</td>
                            <td>{{ $jenis->deskripsi }}</td>
                            <td class="text-center">
                                    <a href="{{ route('jenis_kendaraan.edit', ['id' => $jenis->id]) }}"
                                        class="btn btn-warning" wire:navigate>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </a>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm"> <i
                                        class="fas fa-trash-can"></i><span
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
