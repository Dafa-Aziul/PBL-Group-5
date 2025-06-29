<div>
    <h2 class="mt-4">Kelola Jenis Jasa</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('jasa.view') }}">Jenis Kendaraan</a></li>
        <li class="breadcrumb-item active">Daftar Jenis Jasa Service</li>
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
                <span class="d-none d-md-inline ms-1">Daftar jasa</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('jasa.create') }}" wire:navigate>
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah jenis jasa</span>
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama Jasa</th>
                            <th>Jenis Kendaraan</th>
                            <th>Estimasi</th>
                            <th>Harga</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        @forelse ($jasas as $jasa)
                        <tr>
                            <td class="text-center">{{ ($jasas->firstItem() +$loop->iteration) - 1 }}</td>
                            <td>{{ $jasa->kode}}</td>
                            <td>{{ $jasa->nama_jasa}}</td>
                            <td>{{ $jasa->jenisKendaraan->nama_jenis ?? '-' }}</td>
                            <td>
                                @php
                                [$jam, $menit] = explode(':', $jasa->estimasi);
                                @endphp
                                {{ (int) $jam }} jam {{ (int) $menit }} menit
                            </td>

                            <td>Rp {{ number_format($jasa->harga, 0, ',', '.') }}</td>
                            <td>{{ $jasa->keterangan}}</td>
                            <td class="text-center">

                                <a href="{{ route('jasa.edit', ['id' => $jasa->id]) }}"
                                    class="btn btn-warning mb-3 mb-md-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>
                                <button class="btn btn-danger mb-3 mb-md-2" data-bs-toggle="modal"
                                    data-bs-target="#confirm"> <i class="fas fa-trash-can"></i><span
                                        class="d-none d-md-inline ms-1">Delete</span></button>
                                <x-modal.confirm id="confirm" action="modal" target="delete({{ $jasa->id }})"
                                    content="Apakah anda yakin untuk menghapus data ini?" />
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse
                </table>
            </div>

            {{ $jasas->links() }}
        </div>
    </div>

</div>
