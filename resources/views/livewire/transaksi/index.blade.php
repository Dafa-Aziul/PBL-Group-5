<div>
    @push('scripts')
    <script>
        window.chartData = @json($chartData);
    window.chartJenis = @json($chartJenis);
    </script>

    @endpush
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
                        <h2 class="fw-bold text-dark text-center">
                            Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}
                        </h2>
                    </div>

                </div>
                {{-- Jenis Transaksi --}}
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Jumlah Transaksi
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <h2 class="fw-bold text-dark text-center">{{ $totalTransaksiHariIni }} transaksi</h2>
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
                    <canvas id="myChart" width="280" height="280" wire.ignore></canvas>
                    {{-- <script>
                        window.chartData = @json($chartData);
                    </script> --}}


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
                    <canvas id="jenisChart" width="280" height="280" wire.ignore></canvas>
                    {{-- <script>
                        window.chartJenis = @json($chartJenis);
                    </script> --}}

                </div>

            </div>
        </div>
    </div>


    <div class="row g-2 d-flex justify-content-between align-items-center mb-2">

        <div class="col-12 col-md-4 d-flex align-items-center gap-3">
            <!-- Container form untuk dari dan sampai -->
            <div class="d-flex flex-column flex-md-row gap-3 w-100">
                <!-- From -->
                <div class="d-flex align-items-center gap-2 me-md-0 mb-2 mb-md-0">
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

    <!-- Error Message (if needed, let it appear below input as usual) -->
    @error('tanggalAkhir')
    <div class="text-danger" style="font-size: 0.875em;">{{ $message }}</div>
    @enderror

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-money-bill-wave me-1"></i>
                <span class="d-none d-md-inline ms-1 ">Daftar Transaksi</span>
            </div>
        </div>

        <div class="card-body">
            <div class="row g-3 mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class=" col-2 col-md-2 d-flex align-items-center">
                    <select class="form-select" wire:model.live="perPage" style="width:auto;cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label class="d-none d-md-inline ms-2 mb-0 text-muted">Entries per page</label>
                </div>

                <!-- Search -->
                <div class="position-relative col-5 col-md-3">
                    <input type="text" class="form-control ps-5" placeholder="Search"
                        wire:model.live.debounce.100ms="search" />
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
                            <td>Rp {{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
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
        let chartStatus, chartJenis;
        let myChart = null;
let jenisChart = null;

    function renderStatusChart() {
        const ctx = document.getElementById('myChart');

         window.chartData = @json($chartData);
        window.chartJenis = @json($chartJenis);

        if (!ctx || !window.chartData) return;

        const labels = window.chartData.labels;
        const values = window.chartData.data;

        if (chartStatus) chartStatus.destroy(); // Hapus chart lama jika ada

        chartStatus = new Chart(ctx, {
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
    }

    function renderJenisChart() {
        const ctx = document.getElementById('jenisChart');

        if (!ctx || !window.chartJenis) return;

        const labels = window.chartJenis.labels;
        const values = window.chartJenis.data;

        if (chartJenis) chartJenis.destroy(); // Hapus chart lama jika ada

        chartJenis = new Chart(ctx, {
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
    }

    document.addEventListener('chart-updated', function (event) {
        const chartData = event.detail.chartData;
        const chartJenis = event.detail.chartJenis;

        // Render ulang grafik (pastikan kamu sudah buat fungsi ini)
        renderStatusChart(chartData);
        renderJenisChart(chartJenis);
    });

    //    document.addEventListener('livewire:load', () => {
    //     Livewire.on('chartUpdated', ({ chartData, chartJenis }) => {
    //         renderStatusChart(chartData);
    //         renderJenisChart(chartJenis);
    //     });
    // });




    document.addEventListener("livewire:navigated", () => {
        renderStatusChart();
        renderJenisChart();
    });

    
    document.addEventListener("DOMContentLoaded", () => {
        renderStatusChart();
        renderJenisChart();
    });

    // Trigger ulang chart setelah Livewire selesai render
    Livewire.hook('message.processed', () => {
        renderStatusChart();
        renderJenisChart();
    });

    

    </script>
    @endpush





</div>