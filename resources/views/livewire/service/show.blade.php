@push('scripts')
<script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }

    function copyKodeService(button) {
        const kode = document.getElementById("kodeService").innerText;
        navigator.clipboard.writeText(kode).then(() => {
            const tooltip = bootstrap.Tooltip.getInstance(button);
            if (tooltip) {
                // Ubah isi tooltip
                tooltip.setContent({ '.tooltip-inner': 'Disalin!' });
                tooltip.show();

                // Setelah 1.5 detik, kembalikan ke pesan awal dan sembunyikan tooltip
                setTimeout(() => {
                    tooltip.setContent({ '.tooltip-inner': 'Salin Kode' });
                    tooltip.hide(); // Paksa tooltip ditutup
                }, 1500);
            }
        });
    }


    document.addEventListener("DOMContentLoaded", function () {
        initTooltips();
    });

    // Untuk Livewire v3 navigasi
    document.addEventListener("livewire:navigated", function () {
        initTooltips();
    });

    // Pastikan fungsi bisa diakses global
    window.copyKodeService = copyKodeService;
</script>
@endpush


<div>
    <h2 class="mt-4">Kelola Service</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a wire:navigate class="text-primary text-decoration-none" href="{{ route('service.view') }}">Service</a>
        </li>
        <li class="breadcrumb-item">
            <a wire:navigate class="text-primary text-decoration-none" href="{{ route('service.view') }}">Daftar
                Service</a>
        </li>
        <li class="breadcrumb-item active">
            <div class="d-flex align-items-center gap-2">
                <span>Detail Data Service :</span>
                <span id="kodeService" class="fw-semibold text-dark">
                    {{ $service->kode_service }}
                </span>
                <button onclick="copyKodeService(this)"
                    class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px; padding: 0;" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Salin Kode">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </div>
        </li>
    </ol>

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Data Service</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{  route('service.view') }}" wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- Nama Pelanggan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pelanggan</label>
                        <div class="form-control bg-light">
                            {{ optional($service->kendaraan->pelanggan)->nama ?? '-' }}
                        </div>
                    </div>

                    <!-- Detail Kendaraan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Detail Kendaraan</label>

                        <div class="form-control bg-light mb-1">
                            <strong>No. Polisi:</strong> {{ $service->no_polisi ?? '-' }}
                        </div>

                        <div class="form-control bg-light mb-1">
                            <strong>Odometer:</strong> {{ $service->odometer ?? '-' }} km
                        </div>

                        <div class="form-control bg-light mb-1">
                            <strong>Tipe Kendaraan:</strong> {{ $service->tipe_kendaraan ?? '-' }}
                        </div>

                        <div class="form-control bg-light mb-1">
                            <strong>Jenis Kendaraan:</strong> {{
                            optional($service->kendaraan->jenis_kendaraan)->nama_jenis ?? '-' }}
                        </div>
                    </div>


                </div>

                <div class="col-md-6">
                    <!-- Montir -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Montir</label>
                        <div class="form-control bg-light">
                            {{ optional($service->montir)->nama ?? '-' }}
                        </div>
                    </div>

                    <!-- Keluhan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keluhan</label>
                        <textarea class="form-control bg-light" rows="3" readonly
                            style="overflow-y: auto; resize: none;">{{ $service->deskripsi_keluhan ?? '-' }}
                        </textarea>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">
                            {{ $service->keterangan ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .timeline-container {
                    border-left: 3px solid #0d6efd;
                    /* warna biru bootstrap */
                    margin-left: 20px;
                    padding-left: 15px;
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                }

                .timeline-item {
                    display: flex;
                    align-items: flex-start;
                    position: relative;
                    gap: 15px;
                }

                .timeline-marker {
                    width: 18px;
                    height: 18px;
                    border: 3px solid white;
                    border-radius: 50%;
                    margin-top: 6px;
                    /* agar sejajar dengan judul */
                    flex-shrink: 0;
                }

                /* warna background marker berdasarkan kelas bg-* Bootstrap,
   misalnya bg-primary, bg-success, dll sudah ada di Bootstrap, jadi tinggal pakai */

                .timeline-content h6 {
                    margin: 0;
                    font-weight: 600;
                }

                .timeline-content small {
                    display: block;
                    color: #6c757d;
                    margin-bottom: 5px;
                }

                .timeline-content p {
                    margin: 0;
                }
            </style>
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-stream me-2"></i>
                    <strong>Log Status Service</strong>
                </div>
                <div class="card-body">
                    <div class="timeline-container position-relative ps-3">

                        @forelse ($service->statuses->sortBy('created_at') as $status)
                        <div class="timeline-item d-flex mb-4">
                            {{-- Marker --}}
                            <div class="timeline-marker me-3 mt-1">
                                <i class="fas fa-circle text-{{ $this->getStatusColor($status->status) }}"></i>
                            </div>

                            {{-- Content --}}
                            <div class="timeline-content">
                                <h5 class="mb-1 fw-bold text-capitalize">
                                    {{ $status->status }}
                                </h5>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{
                                    \Carbon\Carbon::parse($status->created_at)->format('d M Y H:i') }}
                                </small>
                                <p class="mb-0 mt-1 fs-6">{{ $status->keterangan ?? '-' }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-muted fst-italic">Belum ada status tercatat.</div>
                        @endforelse

                    </div>
                </div>
            </div>

            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-tools me-2"></i>
                    <strong>Detail Penggunaan Jasa & Sparepart</strong>
                </div>
                <div class="card-body">

                    {{-- 1. Tabel Jasa --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">1. Jasa</label>
                        @if ($service->jasas->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle ">
                                <thead class="table-success text-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Kode</th>
                                        <th>Nama Jasa</th>
                                        <th style="width: 50px;">Qty</th>
                                        <th style="width: 70px;">Satuan</th>
                                        @can('akses-admin-owner')
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service->jasas as $index => $jasa)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge bg-secondary">{{ $jasa->jasa->kode ?? '-' }}</span></td>
                                        <td class="text-start">{{ $jasa->jasa->nama_jasa }}</td>
                                        <td class="text-center"> - </td>
                                        <td class="text-center"> - </td>
                                        @can('akses-admin-owner')
                                        <td class="text-end">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                    @can('akses-admin-owner')
                                    <tr class="table-light fw-bold">
                                        <td colspan="6" d>Total Biaya Jasa</td>
                                        <td class="text-end text-success">Rp {{ number_format($totalJasa, 0, ',', '.')
                                            }}</td>
                                    </tr>
                                    @endcan
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted fst-italic">Belum ada jasa yang digunakan.</p>
                        @endif
                    </div>

                    {{-- 2. Tabel Sparepart --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">2. Sparepart</label>
                        @if ($service->spareparts->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-success text-dark">
                                    <tr class="text-center">
                                        <th style="width: 50px;">No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th style="width: 50px;">Qty</th>
                                        <th style="width: 70px;">Satuan</th>
                                        @can('akses-admin-owner')
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($service->spareparts as $index => $sp)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge bg-info text-dark">{{ $sp->sparepart->kode ?? '-'
                                                }}</span></td>
                                        <td>{{ $sp->sparepart->nama }}</td>
                                        <td class="text-center">{{ $sp->jumlah ?? '-' }}</td>
                                        <td class="text-center">{{ $sp->sparepart->satuan ?? '-' }}</td>
                                        @can('akses-admin-owner')
                                        <td class="text-end">Rp {{ number_format($sp->harga, 0, ',', '.') }}</td>
                                        <td class="text-end fw-semibold text-primary">Rp {{
                                            number_format($sp->sub_total,
                                            0, ',', '.') }}</td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                    @can('akses-admin-owner')
                                    <tr class="table-light fw-bold">
                                        <td colspan="6" class="">Total Biaya Sparepart</td>
                                        <td class="text-end text-success">Rp {{ number_format($totalSparepart, 0, ',',
                                            '.') }}</td>
                                    </tr>
                                    @endcan
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted fst-italic">Belum ada sparepart yang digunakan.</p>
                        @endif
                    </div>

                    {{-- 3. Estimasi Biaya --}}
                    @if($totalJasa > 0 || $totalSparepart > 0)
                    <div class="alert alert-primary shadow-sm d-flex align-items-start gap-3" role="alert">
                        <i class="fas fa-info-circle text-info fs-3 mt-1"></i>
                        <div>
                            <div class="fw-semibold text-muted small mb-2">Rincian Estimasi</div>

                            {{-- Baris: Estimasi Biaya --}}
                            @can('akses-admin-owner')
                            <div class="d-flex align-items-center text-success mb-2">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <div>
                                    <strong>Total Estimasi Biaya:</strong>
                                    <span class="fs-5 ms-1">Rp {{ number_format($totalEstimasi, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            @endcan

                            {{-- Baris: Estimasi Waktu --}}
                            <div class="d-flex align-items-center text-primary">
                                <i class="fas fa-stopwatch me-2"></i>
                                <div>
                                    <strong>Total Estimasi Waktu:</strong>
                                    <span class="fs-5 ms-1">{{ $estimasiWaktuReadable }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif



                </div>
            </div>




        </div>
    </div>
</div>
