<div>
    <h2 class="mt-4">Manajemen Transaksi</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Transaksi</a></li>
        <li class="breadcrumb-item active">Daftar Transaksi</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-money-bill-wave me-1"></i>
                <span class="d-none d-md-inline ms-1 ">Daftar Transaksi</span>
            </div>
            {{-- <div>
                <a class="btn btn-primary float-end" href="{{ route('transaksi.create') }}" wire:navigate>
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah Transaksi</span>
                </a>
            </div> --}}
        </div>

        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class="d-flex align-items-center">
                    <select class="form-select" wire:model.live="perPage" style="width:auto;cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label class="d-none d-md-inline ms-2 mb-0 text-muted">Entries per page</label>
                </div>

                <!-- Search -->
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Search"
                        wire:model.live.debounce.100ms="search">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Kode Transaksi</th>
                            <th>Kasir</th>
                            <th>Pelanggan</th>
                            <th>Jenis</th>
                            <th>Subtotal</th>
                            <th>Pajak (11%)</th>
                            <th>Diskon (%)</th>
                            <th>Total</th>
                            <th>Status Pembayaran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $transaksi)
                        <tr style="cursor: pointer;" x-data
                            @click="Livewire.navigate(`/transaksi/{{ $transaksi->id }}`)">
                            <td class="text-center">{{ ($transaksis->firstItem() + $loop->iteration) - 1 }}</td>
                            <td>{{ $transaksi->kode_transaksi }}</td>
                            <td>{{ $transaksi->kasir->nama ?? '-' }}</td>
                            <td>{{ $transaksi->pelanggan->nama ?? '-' }}</td>
                            <td>{{ ucfirst($transaksi->jenis_transaksi) }}</td>
                            <td>Rp {{ number_format($transaksi->sub_total, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($transaksi->pajak, 0, ',', '.') }}</td>
                            <td>{{ number_format($transaksi->diskon, 0, ',', '.')  }} %</td>
                            <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                            <td>
                                @if ($transaksi->status_pembayaran == 'lunas')
                                <span class="badge bg-success">Lunas</span>
                                @elseif ($transaksi->status_pembayaran == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $transaksi->keterangan }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">Tidak ada transaksi yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $transaksis->links() }}
        </div>
    </div>

</div>
