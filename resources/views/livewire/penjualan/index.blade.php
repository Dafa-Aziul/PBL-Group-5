<div>
    <h2 class="mt-4">Manajemen Penjualan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('penjualan.view') }}">Penjualan</a></li>
        <li class="breadcrumb-item active">Daftar Penjualan</li>
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

    <div class="row g-2 d-flex justify-content-between align-items-center mb-2">

        <div class="col-12 col-md-4 d-flex align-items-center gap-3">
            <!-- Container form untuk dari dan sampai -->
            <div class="d-flex flex-column flex-md-row gap-3 w-100">
                <!-- From -->
                <div class="d-flex align-items-center gap-2 me-md-4 mb-2 mb-md-0">
                    <label for="tanggalAwal" class="form-label mb-0" style="width: 50px;">From:</label>
                    <input type="date" id="tanggalAwal" wire:model="tanggalAwal" class="form-control" @if($showAll)
                        disabled @endif>
                </div>

                <!-- To -->
                <div class="d-flex align-items-center gap-2 me-md-4 mb-2 mb-md-0">
                    <label for="tanggalAkhir" class="form-label mb-0" style="width: 50px;">To :</label>
                    <input type="date" id="tanggalAkhir" wire:model.live="tanggalAkhir" class="form-control"
                        @if($showAll) disabled @endif>
                </div>

            </div>
        </div>


        <!-- Reset Button -->
        <div class="col-12 col-md-3 d-flex justify-content-between justify-content-md-end gap-2 mb-2    ">
            <!-- Checkbox "Semua" -->
            <div>
                <input type="checkbox" class="btn-check" id="showAllCheck" wire:model.live="showAll" autocomplete="off">
                <label class="btn btn-outline-primary mb-0" for="showAllCheck">
                    Semua
                </label>
            </div>

            <!-- Tombol Reset -->
            <button wire:click="resetFilter" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="fas fa-rotate me-1"></i>
                <span class="d-none d-md-inline">Reset Filter</span>
            </button>
        </div>


    </div>

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Daftar service</span>
            </div>
            <div>
                @can('admin')
                <a class="btn btn-primary float-end" href="{{ route('penjualan.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah Penjualan</span>
                </a>
                @endcan
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
                            <th>Kode Transaksi</th>
                            <th>Kasir</th>
                            <th>Pelanggan</th>
                            <th>Subtotal</th>
                            <th>Pajak (11%)</th>
                            <th>Diskon (%)</th>
                            <th>Total</th>
                            <th>Status Pembayaran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualans as $penjualan)
                        <tr style="cursor: pointer;" x-data
                            @click="Livewire.navigate(`/penjualan/{{ $penjualan->id }}`)">
                            <td class="text-center">{{ ($penjualans->firstItem() + $loop->iteration) - 1 }}</td>
                            <td>{{ $penjualan->kode_transaksi }}</td>
                            <td>{{ $penjualan->kasir->nama ?? '-' }}</td>
                            <td>{{ $penjualan->pelanggan->nama ?? '-' }}</td>
                            <td>Rp {{ number_format($penjualan->sub_total, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($penjualan->pajak, 0, ',', '.') }}</td>
                            <td>{{ number_format($penjualan->diskon, 0, ',', '.')  }} %</td>
                            <td>Rp {{ number_format($penjualan->grand_total, 0, ',', '.') }}</td>
                            <td>
                                @if ($penjualan->status_pembayaran == 'lunas')
                                <span class="badge bg-success">Lunas</span>
                                @elseif ($penjualan->status_pembayaran == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $penjualan->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">Tidak ada transaksi yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

</div>
