<div>
    Manajemen Transaksi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Transaksi</a></li>
        <li class="breadcrumb-item active">Daftar Transaksi</li>
        <li class="breadcrumb-item active">Tambah Transaksi Service : {{ $service->kode_service }}</li>
    </ol>
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
                        <strong>Model Kendaraan:</strong> {{ $service->model_kendaraan ?? '-' }}
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
                    <textarea class="form-control bg-light" rows="3" readonly style="overflow-y: auto; resize: none;">{{ $service->deskripsi_keluhan ?? '-' }}
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
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-header bg-success text-white d-flex align-items-center">
                <i class="fas fa-tools me-2"></i>
                <strong>Detail Penggunaan Jasa & Sparepart</strong>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="store">
                    <div class="mb-3">
                        <label for="kode_transaksi" class="form-label"> Kode Transaksi</label>
                        <input class="form-control" wire:model="form.kode_transaksi" id="kode_transaksi">
                        </input>
                        @error('form.kode_transaksi') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
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
                                        <th>Harga</th>
                                        <th>Subtotal</th>
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
                                        <td class="text-end">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($jasa->harga ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-light fw-bold">
                                        <td colspan="6" d>Total Biaya Jasa</td>
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
                                        <th>Harga</th>
                                        <th>Subtotal</th>
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
                                        <td class="text-end">Rp {{ number_format($sp->harga, 0, ',', '.') }}</td>
                                        <td class="text-end fw-semibold text-primary">Rp {{ number_format($sp->subtotal,
                                            0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-light fw-bold">
                                        <td colspan="6" class="">Total Biaya Sparepart</td>
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

                    {{-- 3. Estimasi Biaya --}}
                    @if($totalJasa > 0 || $totalSparepart > 0)
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="fas fa-calculator me-2"></i>
                        <div>
                            <strong>Total Biaya:</strong>
                            <span class="text-success fs-5 ms-2">Rp {{ number_format($service->estimasi_harga, 0, ',',
                                '.')
                                }}</span>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="pajak" class="form-label">Pajak 11%</label>
                            <div class="form-control mb-1">
                                Rp {{ number_format($this->form->pajak, 0, ',', '.')}}
                            </div>
                            @error('pajak') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="diskon">Diskon (%)</label>
                            <input type="number" min="0" max="100" class="form-control" wire:model.lazy="form.diskon"
                                id="diskon">
                            @error('form.diskon') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="diskon">Diskon (Rp)</label>
                            <div class="form-control mb-1">
                                Rp {{ number_format($this->total_diskon, 0, ',', '.')}}
                            </div>
                            @error('') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="total">Total</label>
                            <div class="form-control mb-1">
                                Rp {{ number_format($this->form->total, 0, ',', '.')}}
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                        <select class="form-select" wire:model="form.status_pembayaran" id="status_pembayaran">
                            <option value="pending">Pending</option>
                            <option value="lunas">Lunas</option>
                        </select>
                        @error('form.status_pembayaran') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" wire:model="form.keterangan" id="keterangan" rows="3"></textarea>
                        @error('form.keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fa-solid fa-paper-plane me-1"></i> Simpan Transaksi
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>