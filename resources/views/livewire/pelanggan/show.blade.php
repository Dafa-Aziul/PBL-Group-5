<div>
    <h1 class="mt-4">Kelola Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Pelanggan</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Daftar Pelanggan</a></li>
        <li class="breadcrumb-item active">Detail Data Pelanggan : {{ $pelanggan->nama }}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Data Pelanggan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{  route('pelanggan.view') }}" wire:navigate>
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
                        <div class="form-control bg-light">{{ $pelanggan->nama }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <div class="form-control bg-light">{{ $pelanggan->email }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No HP</label>
                        <div class="form-control bg-light">{{ $pelanggan->no_hp }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <div class="form-control bg-light">{{ $pelanggan->alamat }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">{{ $pelanggan->keterangan }}</div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold mb-0">Daftar Kendaraan</label>
                            <a class="btn btn-primary" href="{{ route('kendaraan.create', ['id' => $pelanggan->id]) }}" wire:navigate>
                                <i class="fas fa-plus"></i>
                                <span class="d-none d-md-inline ms-1">Tambah Kendaraan</span>
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>No.</th>
                                        <th>No Polisi</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Tipe</th>
                                        <th>Odometer</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pelanggan->kendaraans as $index => $kendaraan)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $kendaraan->no_polisi }}</td>
                                        <td>{{ $kendaraan->jenis_kendaraan->nama_jenis ?? '-' }}</td>
                                        <td>{{ $kendaraan->model_kendaraan }}</td>
                                        <td>{{ $kendaraan->odometer }} km</td>
                                        <td class="text-center">
                                            <a href="" class="btn btn-warning btn-sm" wire:navigate>
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span class="d-none d-md-inline ms-1">Riwayat Service<s/span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada kendaraan terdaftar.
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
