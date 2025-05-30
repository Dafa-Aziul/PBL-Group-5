<div>
    <h2 class="mt-4">Manajemen Transaksi</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Transaksi</a></li>
        <li class="breadcrumb-item active">Daftar Transaksi</li>
    </ol>
    <div class="row g-3 mb-4">
        {{-- Kanan atas: Status + Jenis dalam satu kolom besar (75%) --}}
        <div class="col-12 col-lg-4">
            <div class="d-flex flex-column h-100 justify-content-between gap-3">
                {{-- Status Pembayaran --}}
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-money-bill-1-wave"></i> Total Pendapatan
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <h2 class="fw-bold text-dark text-center" >
                            Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}
                        </h2>
                    </div>

                </div>
                {{-- Jenis Transaksi --}}
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Total Transaksi
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <h2 class="fw-bold text-dark text-center">{{ $totalTransaksiHariIni }} transaksi hari ini</h2>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card card-jumlah h-100 card-hover">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fa-solid fa-comments-dollar"></i> Status Pembayaran
                    </h5>
                    <hr class="border border-2 opacity-50">
                    <canvas id="myChart" width="280" height="280"></canvas>
                    <script>
                        window.chartData = @json($chartData);
                    </script>
                </div>

            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card card-jumlah h-100 card-hover">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fa-solid fa-list"></i> Jenis Transaksi
                    </h5>
                    <hr class="border border-2 opacity-50">
                    <canvas id="jenisChart" width="280" height="280"></canvas>
                    <script>
                        window.chartJenis = @json($chartJenis);
                    </script>
                </div>

            </div>
        </div>
    </div>

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
                            <td>{{ number_format($transaksi->diskon, 0, ',', '.') }} %</td>
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
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('myChart');

        const chartData = window.chartData;
        const labels = chartData.labels;
        const values = chartData.data;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Status Pembayaran',
                    data: values,
                    backgroundColor: [
                        'rgb(75, 192, 192)', // Lunas
                        'rgb(255, 205, 86)'  // Pending
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('jenisChart');

        const chartJenis = window.chartJenis;
        const labels = chartJenis.labels;
        const values = chartJenis.data;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jenis Service',
                    data: values,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)'  
                        
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    });
    </script>
    @endpush




</div>