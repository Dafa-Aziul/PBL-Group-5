<div>
    <h1 class="mt-4">Kelola sparepart</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('sparepart.view') }}">Jenis Sparepart</a></li>
        <li class="breadcrumb-item active">Daftar Sparepart</li>
    </ol>
    @if (session()->has('success'))
    <div class="        ">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div @elseif (session()->has('error'))
    <div class="">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
    @endif


    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Daftar sparepart</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('sparepart.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah sparepart</span>
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
                            <th>Kode</th>
                            <th>Nama Sparepart</th>
                            <th>Merk Sparepart</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Model Kendaraan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        @forelse ($spareparts as $sparepart)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $sparepart->kode}}</td>
                            <td>{{ $sparepart->nama}}</td>
                            <td>{{ $sparepart->merk}}</td>
                            <td>{{ $sparepart->satuan}}</td>
                            <td>{{ $sparepart->stok }}</td>


                            <td>Rp {{ number_format($sparepart->harga, 0, ',', '.') }}
                            <td>{{ $sparepart->model_kendaraan}}</td>
                            <td>{{ $sparepart->ket}}</td>

                            <td class="text-center">
                                <a href="{{ route('sparepart.edit', ['id' => $sparepart->id]) }}"
                                    class="btn btn-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm"> <i
                                        class="fas fa-trash-can"></i><span
                                        class="d-none d-md-inline ms-1">Delete</span></button>
                                <x-modal.confirm id="confirm" action="modal" target="delete({{ $sparepart->id }})"
                                    content="Apakah anda yakin untuk menghapus data ini?" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse
                </table>
            </div>

            {{ $spareparts->links() }}
        </div>
    </div>

</div>