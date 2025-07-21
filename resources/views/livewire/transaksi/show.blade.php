@push('scripts')
<script>
    // Menangani pemanggilan modal
    window.addEventListener('open-payment-modal', event => {
        const modalEl = document.getElementById('paymentModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });

    // Menangani penutupan modal
    window.addEventListener('hide-payment-modal', event => {
        const modalEl = document.getElementById('paymentModal');
        const modal = bootstrap.Modal.getInstance(modalEl);

        if (modal) {
            modal.hide();
        }

        // Tambahan: bersihkan backdrop jika tertinggal
        setTimeout(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        }, 300); // delay kecil untuk pastikan transisi selesai
    });

    // Opsional: Jika pakai Livewire, tambahkan hook
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', () => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        });
    });
</script>
<script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }

    function copyKodeTransaksi(button) {
        const kode = document.getElementById("KodeTransaksi").innerText;
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
    window.copyKodeTransaksi = copyKodeTransaksi;
</script>
@endpush
<div>
    <h2 class="mt-4">Manajemen Transaksi</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('transaksi.view') }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('transaksi.view') }}">Daftar Transaksi</a></li>
        <li class="breadcrumb-item active">
            <div class="d-flex align-items-center gap-2">
                <span>Detail Transaksi :</span>
                <span id="KodeTransaksi" class="fw-semibold text-dark">
                    {{ $transaksi->kode_transaksi }}
                </span>
                <button onclick="copyKodeTransaksi(this)"
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
                <span class="ms-1">Data Transaksi</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{  route('transaksi.view') }}" wire:navigate>
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
                            {{ optional($transaksi->pelanggan)->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kasir</label>
                        <div class="form-control bg-light">
                            {{ optional($transaksi->kasir)->nama ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Transaksi</label>
                        <div class="form-control bg-light text-capitalize">
                            {{ $transaksi->jenis_transaksi ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- Detail Pembayaran -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Pembayaran</label>
                        <div class="form-control bg-light text-capitalize">
                            {{ $transaksi->status_pembayaran ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">
                            {{ $transaksi->keterangan ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Transaksi</label>
                        <div class="form-control bg-light">
                            {{ $transaksi->created_at->format('d M Y H:i') }}
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

            <!-- Log Status Pembayaran -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-success text-white justify-content-between d-flex align-items-center">
                    <div class="">
                        <i class="fas fa-credit-card me-2"></i>
                        <strong>Log Status Pembayaran</strong>
                    </div>

                    @if($transaksi->status_pembayaran != 'lunas')
                    @can('admin')
                    <button class="btn bg-white text-success btn-success" data-bs-toggle="modal"
                        data-bs-target="#paymentModal">
                        <i class="fas fa-money-bill-wave"></i> <span class="d-none d-md-inline ms-1">Bayar
                            Sekarang</span>
                    </button>
                    @endcan
                    @endif
                </div>
                <div class="card-body">
                    <!-- Tampilkan sisa pembayaran dengan badge warna -->
                    <div class="mb-4">
                        <h5>
                            <span class="badge bg-{{ $sisaPembayaran > 0 ? 'warning' : 'success' }} fs-6">
                                Sisa Pembayaran: Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}
                            </span>
                        </h5>
                    </div>

                    <div class="timeline-container position-relative ps-3">
                        @forelse ($transaksi->pembayarans->sortBy('created_at') as $pembayaran)
                        <div class="timeline-item d-flex mb-4">
                            <div class="timeline-marker me-3 mt-1">
                                <i
                                    class="fas fa-circle text-{{ $pembayaran->status_pembayaran == 'lunas' ? 'success' : 'warning' }}"></i>
                            </div>
                            <div class="timeline-content">
                                <h5 class="mb-1 fw-bold text-capitalize">
                                    {{ $pembayaran->status_pembayaran }}
                                </h5>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d M Y H:i') }}
                                </small>
                                <p class="mb-0 mt-1 fs-6">
                                    <strong>Jumlah Bayar:</strong> Rp {{ number_format($pembayaran->jumlah_bayar, 0,
                                    ',', '.') }}
                                </p>
                                <p class="mb-0 fs-6">
                                    <strong>Keterangan:</strong> {{ $pembayaran->ket ?? '-' }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="text-muted fst-italic">Belum ada status pembayaran tercatat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Form Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form wire:submit.prevent="simpanPembayaran">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tanggal Bayar</label>
                                    <input type="date" class="form-control" wire:model.defer="form.tanggal_bayar">
                                    @error('form.tanggal_bayar') <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Jumlah Bayar (Sisa: Rp{{ number_format($sisaPembayaran, 0, ',', '.')
                                        }})</label>
                                    <input type="number" class="form-control" wire:model.defer="form.jumlah_bayar">
                                    @error('form.jumlah_bayar') <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" wire:model.defer="form.ket"></textarea>
                                    @error('form.ket') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary"
                                    wire:loading.attr="disabled">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Detail Penggunaan Jasa & Sparepart -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-tools me-2"></i>
                    <strong>Detail Penggunaan Jasa & Sparepart</strong>
                </div>
                <div class="card-body">
                    {{-- 1. Tabel Jasa --}}
                    @if ($transaksi->jenis_transaksi === 'service')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">1. Jasa</label>
                        @php
                        // Ambil semua jasa dari relasi transaksi->serviceDetail->service->jasas
                        $jasas = $transaksi->serviceDetail
                        ? $transaksi->serviceDetail->service->jasas
                        : collect();
                        $totalJasa = $jasas->sum(fn($jasa) => $jasa->harga ?? 0);
                        @endphp

                        @if ($jasas->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-success text-dark">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Kode</th>
                                        <th>Nama Jasa</th>
                                        <th style="width: 50px;">Qty</th>
                                        <th style="width: 70px;">Satuan</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jasas as $index => $jasa)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><span class="badge bg-secondary">{{ $jasa->jasa->kode ?? '-' }}</span></td>
                                        <td class="text-start">{{ $jasa->jasa->nama_jasa }}</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">-</td>
                                        <td class="text-end">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-light fw-bold">
                                        <td colspan="6">Total Biaya Jasa</td>
                                        <td class="text-end text-success">Rp {{ number_format($totalJasa, 0, ',', '.')
                                            }}</td>
                                    </tr>
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
                        @php
                        // Ambil semua sparepart dari relasi transaksi->serviceDetail->service->spareparts
                        $spareparts = $transaksi->serviceDetail
                        ? $transaksi->serviceDetail->service->spareparts
                        : collect();
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
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pajak" class="form-label">Subtotal</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($transaksi->sub_total, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pajak" class="form-label">Pajak 11%</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($transaksi->pajak, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3 ">
                                    <label for="diskon">Diskon (%)</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($transaksi->diskon, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <label for="diskon">Diskon (Rp)</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format(($transaksi->diskon/100)*($transaksi->grand_total) , 0, ',',
                                        '.')}}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="fas fa-calculator me-2"></i>
                                        <div>
                                            <strong>Grand Total: </strong>
                                            <span class="text-success fs-5 ms-2">Rp {{
                                                number_format($transaksi->grand_total,
                                                0,
                                                ',', '.')
                                                }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <p class="text-muted fst-italic">Belum ada sparepart yang digunakan.</p>
                        @endif
                    </div>
                    @elseif ($transaksi->jenis_transaksi === 'penjualan')
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">1. Sparepart</label>
                        @php
                        // Ambil semua sparepart dari relasi transaksi->serviceDetail->service->spareparts
                        $spareparts = $transaksi->penjualanDetail ?? collect();
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
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pajak" class="form-label">Subtotal</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($transaksi->sub_total, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 mb-3">
                                    <label for="pajak" class="form-label">Pajak 11%</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($transaksi->pajak, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3 ">
                                    <label for="diskon">Diskon (%)</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($transaksi->diskon, 0, ',', '.')}}
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-3">
                                    <label for="diskon">Diskon (Rp)</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format(($transaksi->diskon/100)*($transaksi->grand_total) , 0, ',',
                                        '.')}}
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="fas fa-calculator me-2"></i>
                                        <div>
                                            <strong>Grand Total: </strong>
                                            <span class="text-success fs-5 ms-2">Rp {{
                                                number_format($transaksi->grand_total,
                                                0,
                                                ',', '.')
                                                }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <p class="text-muted fst-italic">Belum ada sparepart yang digunakan.</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Total Keseluruhan -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-body d-flex justify-content-end fw-bold fs-5 gap-2">
                    <button data-bs-toggle="modal" data-bs-target="#previewModal" class="btn btn-info">
                        <i class="fa fa-eye"></i>
                        <span class="d-none d-md-inline ms-1">Preview Invoice</span>
                    </button>

                    <a href="{{ route('invoice.download', $transaksi->id) }}" class="btn btn-primary"
                        rel="noopener noreferrer" download>
                        <i class="fa fa-download"></i>
                        <span class="d-none d-md-inline ms-1">Download Invoice</span>
                    </a>
                </div>

            </div>
            <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Preview Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <iframe src="{{ route('invoice.show', $transaksi->id) }}" width="100%" height="600px"
                                frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
