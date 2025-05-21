<div>
    <h1 class="mt-4">Kelola sparepart</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">sparepart</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Daftar sparepart</a></li>
        <li class="breadcrumb-item active">Detail Data sparepart : {{ $sparepart->nama }}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Data sparepart</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{  route('sparepart.view') }}" wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama</label>
                        <div class="form-control bg-light">{{ $sparepart->nama }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Merk</label>
                        <div class="form-control bg-light">{{ $sparepart->merk }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Satuan</label>
                        <div class="form-control bg-light">{{ $sparepart->satuan }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Stok</label>
                        <div class="form-control bg-light">{{ $sparepart->stok }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga</label>
                        <div class="form-control bg-light">{{ $sparepart->harga }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Model Kendaraan</label>
                        <div class="form-control bg-light">{{ $sparepart->model_kendaraan }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">{{ $sparepart->ket }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold mb-0">log gudang</label>
                            <a class="btn btn-primary" href="{{ route('gudang.create', ['id' => $sparepart->id]) }}" wire:navigate>
                                <i class="fas fa-plus"></i>
                                <span class="d-none d-md-inline ms-1">Tambah log gudang</span>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>No.</th>
                                        <th>Sparepart</th>
                                        <th>Aktivitas</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        {{-- <th class="text-center">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sparepart->gudangs as $index => $gudang)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $gudang->sparepart->nama ?? '-' }}</td>
                                        <td>{{ $gudang->aktivitas }}</td>
                                        <td>{{ $gudang->jumlah }}</td>
                                        <td>{{ $gudang->keterangan }}</td>
                                        {{-- <td class="text-center">
                                            <a href="" class="btn btn-warning btn-sm" wire:navigate>
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span class="d-none d-md-inline ms-1">Riwayat Service<s/span>
                                            </a>
                                        </td> --}}
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada monitoring sparepart terdaftar.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
