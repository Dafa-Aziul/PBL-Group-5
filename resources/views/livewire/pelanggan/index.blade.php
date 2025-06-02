<div>
    <h2 class="mt-4">Kelola Pelanggan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="{{ route('pelanggan.view') }}">Pelanggan</a></li>
        <li class="breadcrumb-item active">Daftar Pelanggan</li>
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
                <span class="d-none d-md-inline ms-1 ">Daftar Pelanggan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('pelanggan.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah Pelanggan</span>
                </a>

            </div>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class=" col-2 col-md-2 d-flex align-items-center">
                    <select class="form-select" wire:model.live="perPage" style="width:auto;cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label class="d-none d-md-inline ms-2 mb-0 text-muted">Entries per page</label>
                </div>

                <!-- Search -->
                <div class="position-relative col-5 col-md-3">
                    <input type="text" class="form-control ps-5" placeholder="Search"
                        wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>

            <div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Alamat</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        </tfoot>
                        <tbody>
                            @forelse ($pelanggans as $pelanggan)
                            <tr style="cursor:pointer;"  x-data @click="Livewire.navigate(`/pelanggan/{{ $pelanggan->id }}`)">
                                <td class="text-center">{{($pelanggans->firstItem() + $loop->iteration) - 1}}</td>
                                <td>{{ $pelanggan->nama }}</td>
                                <td>{{ $pelanggan->email }}</td>
                                <td>{{ $pelanggan->no_hp }}</td>
                                <td>{{ $pelanggan->alamat }}</td>
                                <td>{{ $pelanggan->keterangan }}</td>
                                <td class="text-center" @click.stop>
                                    <a href="{{ route('pelanggan.edit', ['id' => $pelanggan->id]) }} " class="btn btn-warning" wire:navigate >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                            @endforelse
                    </table>
                    {{ $pelanggans -> links() }}
                </div>
            </div>
        </div>
    </div>

</div>
