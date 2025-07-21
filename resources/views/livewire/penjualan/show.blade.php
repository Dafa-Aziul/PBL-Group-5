@push('scripts')
<script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }

    function copyKodePenjualan(button) {
        const kode = document.getElementById("KodePenjualan").innerText;
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
    window.copyKodePenjualan = copyKodePenjualan;
</script>
@endpush

<div>
    <h2 class="mt-4">Manajemen Penjualan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('penjualan.view') }}">Penjualan</a>
        </li>
        <li class="breadcrumb-item">
            <a wire:navigate class="text-primary text-decoration-none" href="{{ route('penjualan.view') }}">Daftar
                Penjualan</a>
        </li>
        <li class="breadcrumb-item active">
            <div class="d-flex align-items-center gap-2">
                <span>Detail Penjualan :</span>
                <span id="KodePenjualan" class="fw-semibold text-dark">
                    {{ $penjualan->kode_transaksi }}
                </span>
                <button onclick="copyKodePenjualan(this)"
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
                <i class="fas fa-receipt me-1"></i>
                <span class="d-none d-md-inline ms-1">Data Penjualan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{  route('penjualan.view') }}" wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Info Pelanggan & Kasir -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pelanggan</label>
                        <div class="form-control bg-light">
                            {{ optional($penjualan->pelanggan)->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kasir</label>
                        <div class="form-control bg-light">
                            {{ optional($penjualan->kasir)->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Transaksi</label>
                        <div class="form-control bg-light text-capitalize">
                            {{ $penjualan->jenis_transaksi ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- Detail Pembayaran -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Pembayaran</label>
                        <div class="form-control bg-light text-capitalize">
                            {{ $penjualan->status_pembayaran ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">
                            {{ $penjualan->keterangan ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Transaksi</label>
                        <div class="form-control bg-light">
                            {{ $penjualan->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .timeline-container {
                    border-left: 3px solid #198754;
                    /* hijau bootstrap */
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
                    flex-shrink: 0;
                }

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


            <!-- Detail Penggunaan Jasa & Sparepart -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-tools me-2"></i>
                    <strong>Detail Penjualan</strong>
                </div>
                <div class="card-body">
                    {{-- 1. Tabel Sparepart --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">1. Sparepart</label>
                        @php
                        // Ambil semua sparepart dari relasi penjualan->serviceDetail->service->spareparts
                        $spareparts = $penjualan->penjualanDetail ?? collect();
                        $totalSparepart = $spareparts->sum(fn($sp) => $sp->sub_total ?? 0);
                        @endphp

                        @if ($spareparts->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-success text-dark">
                                    <tr class="text-center">
                                        <th style="width: 50px;">No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th style="width: 50px;">Qty</th>
                                        <th style="width: 70px;">Satuan</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($spareparts as $index => $sp)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge bg-info text-dark">{{ $sp->sparepart->kode ?? '-'
                                                }}</span></td>
                                        <td>{{ $sp->sparepart->nama }}</td>
                                        <td class="text-center">{{ $sp->jumlah ?? '-' }}</td>
                                        <td class="text-center">{{ $sp->sparepart->satuan ?? '-' }}</td>
                                        <td class="text-end">Rp {{ number_format($sp->harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($sp->sub_total ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-light fw-bold">
                                        <td colspan="6">Total Biaya Sparepart</td>
                                        <td class="text-end text-success">Rp {{ number_format($totalSparepart, 0, ',',
                                            '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="mt-2">
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="fas fa-calculator me-2"></i>
                                        <div>
                                            <strong>Total Keseluruhan: </strong>
                                            <span class="text-success fs-5 ms-2">Rp {{
                                                number_format($penjualan->grand_total,
                                                0,
                                                ',', '.')
                                                }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="pajak" class="form-label">Pajak 11%</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($penjualan->pajak, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-3">
                                    <label for="diskon">Diskon (%)</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($penjualan->diskon, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-3">
                                    <label for="diskon">Diskon (Rp)</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format(($penjualan->diskon/100)*($penjualan->grand_total) , 0, ',',
                                        '.')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <p class="text-muted fst-italic">Belum ada sparepart yang digunakan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
