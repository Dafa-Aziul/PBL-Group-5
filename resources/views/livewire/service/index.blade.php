@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('tampilkanModalTransaksi', (serviceId) => {
            console.log('Menerima event tampilkanModalTransaksi:', serviceId); // Debug cek event sampai
            const modalEl = document.getElementById(`modalTransaksi-${serviceId}`);
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            } else {
                console.warn('Modal dengan ID modalTransaksi-' + serviceId + ' tidak ditemukan.');
            }
        });
    });
</script>
@endpush

<div>
    <h2 class="mt-4">Kelola Service</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('service.view') }}">service</a></li>
        <li class="breadcrumb-item active">Daftar service</li>
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
    <div class="modal fade" id="modalTest" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">Ini modal test</div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Daftar service</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('service.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah service</span>
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
                    <label for="perPage" class="d-none d-md-inline ms-2 mb-0 text-muted">Entries per page</label>
                </div>

                <!-- Search Input with Icon -->
                <div class="position-relative" style="width: 30ch;">
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
                                <th>Kode service</th>
                                <th>Pelanggan</th>
                                <th>Nomor Polisi</th>
                                <th>Model Kendaraan</th>
                                <th>status</th>
                                <th>Tanggal Mulai</th>
                                <th>tanggal Selesai</th>
                                <th>keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        </tfoot>
                        <tbody>
                            @forelse ($services as $service)
                            <tr style="cursor:pointer;" x-data @click="Livewire.navigate(`/service/{{ $service->id }}`)"
                                class="align-middle">
                                <td class="text-center">{{ ($services->firstItem() + $loop->iteration) - 1 }}</td>
                                <td>{{ $service->kode_service }}</td>
                                <td>{{ $service->kendaraan->pelanggan->nama }}</td>
                                <td>{{ $service->no_polisi }}</td>
                                <td>{{ $service->model_kendaraan }}</td>
                                <td @click.stop class="text-center">
                                    @if(in_array($service->status, ['selesai', 'batal']))
                                    @if($service->status == 'selesai')
                                    <div class="badge bg-success d-inline-flex align-items-center py-2 px-3 fs-7">
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </div>
                                    @elseif($service->status == 'batal')
                                    <div class="badge bg-danger d-inline-flex align-items-center py-2 px-3 fs-7">
                                        <i class="fas fa-times-circle me-1"></i> Batal
                                    </div>
                                    @endif
                                    @else
                                    <form wire:submit.prevent="updateStatus({{ $service->id }})"
                                        class="d-flex flex-column align-items-start">
                                        <div class="d-flex align-items-center">
                                            <select wire:model="statuses.{{ $service->id }}" class="form-select me-2"
                                                style="width: 160px;">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="dalam antrian">dalam antrian</option>
                                                <option value="dianalisis">dianalisis</option>
                                                <option value="analisis selesai">analisis selesai</option>
                                                <option value="dalam proses">dalam proses</option>
                                                <option value="selesai">selesai</option>
                                                <option value="batal">batal</option>
                                            </select>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                        @error('statuses.' . $service->id)
                                        <small class="text-danger small mt-1">{{ $message }}</small>
                                        @enderror
                                    </form>
                                    <!-- Modal Konfirmasi Transaksi -->
                                    <div wire:ignore.self class="modal fade" id="modalTransaksi-{{ $service->id }}"
                                        tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTransaksiLabel-{{ $service->id }}">
                                                        Konfirmasi Transaksi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Service telah selesai. Apakah Anda ingin melanjutkan ke transaksi
                                                    pembayaran?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Nanti Saja</button>
                                                    <a href="{{ route('transaksi.service', ['id' => $service->id]) }}"
                                                        class="btn btn-primary">Lanjutkan</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </td>

                                <td>{{ \Carbon\Carbon::parse($service->tanggal_mulai_service)->translatedFormat('d F Y
                                    H:i') }}</td>
                                <td>{{
                                    $service->status === 'batal'
                                    ? 'Service dibatalkan'
                                    : ($service->tanggal_selesai_service
                                    ? \Carbon\Carbon::parse($service->tanggal_selesai_service)->translatedFormat('d F Y
                                    H:i')
                                    : 'Service belum selesai')
                                    }}
                                </td>
                                <td>{{ $service->keterangan }}</td>
                                <td class="text-center" @click.stop>
                                    @if (!in_array($service->status, ['selesai', 'batal']))
                                        <a href="{{ route('service.edit', ['id' => $service->id]) }}"
                                            class="btn btn-warning" wire:navigate>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span class="d-none d-md-inline ms-1">Edit</span>
                                        </a>
                                    @endif
                                    @if ($service->status == 'analisis selesai' || $service->status == 'dalam proses' )
                                        <a href="{{ route('service.detail', ['id' => $service->id]) }}" class="btn btn-info"
                                            wire:navigate>
                                            <i class="fa-solid fa-plus"></i>
                                            <span class="d-none d-md-inline ms-1">detail</span>
                                        </a>
                                    @endif

                                    @if (is_null($service->serviceDetail)&& $service->status == 'selesai')
                                        <a href="{{ route('transaksi.service', ['id' => $service->id]) }}" class="btn btn-info"
                                            wire:navigate>
                                            <i class="fa-solid fa-receipt"></i>
                                            <span class="d-none d-md-inline ms-1">Catat Transaksi</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                            @endforelse
                    </table>
                    {{ $services -> links() }}
                </div>
            </div>
        </div>
    </div>

</div>
