<div>
    <h2 class="mt-4">Riwayat Service Kendaraan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Pelanggan</a>
        </li>
        <li class="breadcrumb-item">
            <a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.detail', ['id' => $kendaraan->pelanggan_id]) }}">
                Detail Data Pelanggan : {{ $kendaraan->pelanggan->nama }}
            </a>
        </li>
        <li class="breadcrumb-item active">Detail Kendaraan : {{ $kendaraan->no_polisi }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-car me-1"></i>
                <span class="d-none d-md-inline ms-1">Data Kendaraan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('pelanggan.detail', ['id' => $kendaraan->pelanggan_id]) }}" wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">No Polisi</label>
                    <div class="form-control bg-light">{{ $kendaraan->no_polisi }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Jenis Kendaraan</label>
                    <div class="form-control bg-light">{{ $kendaraan->jenis_kendaraan->nama_jenis ?? '-' }}</div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tipe Kendaraan</label>
                    <div class="form-control bg-light">{{ $kendaraan->tipe_kendaraan }}</div>
                </div>
            </div>

            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white justify-content-between d-flex align-items-center">
                    <div class="">
                        <i class="fas fa-car me-2"></i>
                        <strong>Daftar Riwayat Service</strong>
                    </div>
                    @can('admin')
                    <a class="btn bg-white text-primary btn-primary" href="{{ route('service.create', ['pelanggan_id' => $kendaraan->pelanggan_id, 'selectedKendaraan' => $kendaraan->id]) }}">
                        <i class="fas fa-plus"></i>
                        <span class="d-none d-md-inline ms-1">Tambah service</span>
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Service</th>
                                    <th>Tanggal Service</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kendaraan->services as $index => $service)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $service->kode_service }}</td>
                                    <td>{{ \Carbon\Carbon::parse($service->tanggal_service)->format('d M Y') }}</td>
                                    <td>@if($service->status == 'selesai')
                                    <div class="badge bg-success d-inline-flex align-items-center py-2 px-3 fs-7">
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </div>
                                    @elseif($service->status == 'batal')
                                    <div class="badge bg-danger d-inline-flex align-items-center py-2 px-3 fs-7">
                                        <i class="fas fa-times-circle me-1"></i> Batal
                                    </div>
                                    @endif</td>
                                    <td>{{ $service->keterangan ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('service.show', ['id' => $service->id]) }}"
                                            class="btn btn-info btn-sm" wire:navigate>
                                            <i class="fas fa-eye"></i>
                                            <span class="d-none d-md-inline ms-1">Detail</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada riwayat service.</td>
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
