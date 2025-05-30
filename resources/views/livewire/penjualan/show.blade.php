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

@endpush
<div>
    <h2 class="mt-4">Kelola Penjualan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('transaksi.view') }}">Transaksi</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('transaksi.view') }}">Daftar Transaksi</a></li>
        <li class="breadcrumb-item active">Detail Transaksi : {{ $penjualan->kode_transaksi }}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-receipt me-1"></i>
                <span class="d-none d-md-inline ms-1">Data Transaksi</span>
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

            {{-- <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" wire:ignore.self>
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Form Pembayaran</h5>
                            <button type="button" class="close" data-bs-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <form wire:submit.prevent="simpanPembayaran">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tanggal Bayar</label>
                                    <input type="date" class="form-control" wire:model.defer="tanggal_bayar">
                                    @error('tanggal_bayar') <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Jumlah Bayar</label>
                                    <input type="number" class="form-control" wire:model.defer="jumlah_bayar">
                                    @error('jumlah_bayar') <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" wire:model.defer="ket"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closePaymentModal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}


            <!-- Detail Penggunaan Jasa & Sparepart -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-tools me-2"></i>
                    <strong>Detail Penjualan</strong>
                </div>
                <div class="card-body">
                    {{-- 1. Tabel Jasa --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase">1. Sparepart</label>
                        @php
                        // Ambil semua sparepart dari relasi transaksi->serviceDetail->service->spareparts
                        $spareparts = $penjualan->penjualanDetail ?? collect();
                        $totalSparepart = $spareparts->sum(fn($sp) => $sp->subtotal ?? 0);
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
                                        <td class="text-end">Rp {{ number_format($sp->subtotal ?? 0, 0, ',', '.') }}
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
                        </div>
                        @else
                        <p class="text-muted fst-italic">Belum ada sparepart yang digunakan.</p>
                        @endif
                    </div>

                </div>
            </div>

            <!-- Total Keseluruhan -->
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-body d-flex justify-content-end fw-bold fs-5">
                    <span class="me-2">Total Keseluruhan: </span>
                    <span class="text-success">
                        Rp {{ number_format($penjualan->total,
                        0,
                        ',',
                        '.'
                        ) }}
                    </span>
                </div>
            </div>

        </div>

    </div>
</div>
</div>
