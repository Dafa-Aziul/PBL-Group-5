@push('scripts')
<script>
    (function () {
    let statusPembayaranChartInstance = null;
    let sparepartChartInstance = null;
    let livewireListenersAttached = false;
    let chartInitialized = false;

    function safeDestroyChart(instance) {
        if (instance) {
            try {
                instance.destroy();
            } catch (e) {
                console.warn('Gagal menghancurkan chart:', e);
            }
        }
        return null;
    }

    function renderStatusPembayaranChart(chartData) {
        const ctx = document.getElementById('statusChartPembayaran');
        if (!ctx) {
            return;
        }

        if (!chartData || !Array.isArray(chartData.labels) || !chartData.datasets || !Array.isArray(chartData.datasets.data)) {
            return;
        }

        const dataset = chartData.datasets;
        const existingChart = Chart.getChart(ctx);

        if (existingChart) {
            existingChart.data.labels = chartData.labels;
            existingChart.data.datasets[0].data = dataset.data;
            existingChart.data.datasets[0].backgroundColor = dataset.backgroundColor;
            existingChart.data.datasets[0].borderColor = dataset.borderColor;
            existingChart.update();
            statusPembayaranChartInstance = existingChart;
        } else {
            statusPembayaranChartInstance = safeDestroyChart(statusPembayaranChartInstance);

            statusPembayaranChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: chartData.labels,
                    datasets: [dataset]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw ?? 0;
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    function renderSparepartChart(chartData) {
        const ctx = document.getElementById('sparepartChart');
        if (!ctx) {
            return;
        }

        if (!chartData || !Array.isArray(chartData.labels) || !chartData.datasets || !Array.isArray(chartData.datasets)) {
            return;
        }

        const existingChart = Chart.getChart(ctx);

        if (existingChart) {
            existingChart.data.labels = chartData.labels;

            chartData.datasets.forEach((newDataset, index) => {
                if (existingChart.data.datasets[index]) {
                    existingChart.data.datasets[index].data = newDataset.data;
                    existingChart.data.datasets[index].label = newDataset.label;
                    existingChart.data.datasets[index].backgroundColor = newDataset.backgroundColor;
                } else {
                    existingChart.data.datasets.push(newDataset);
                }
            });

            existingChart.update();
        } else {
            sparepartChartInstance = safeDestroyChart(sparepartChartInstance);

            sparepartChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: chartData.datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.label}: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    }

    function attachLivewireListeners() {
        if (livewireListenersAttached || !window.Livewire || typeof Livewire.on !== 'function') return;

        Livewire.on('chart-status-pembayaran-updated', (event) => {
            renderStatusPembayaranChart(event?.chartData ?? event);
        });

        Livewire.on('chart-sparepart-updated', (event) => {
            renderSparepartChart(event?.chartData ?? event);
        });

        livewireListenersAttached = true;
    }

    function initializeChart() {
        if (chartInitialized) return;

        const statusCanvas = document.getElementById('statusChartPembayaran');
        const sparepartCanvas = document.getElementById('sparepartChart');

        if (!statusCanvas && !sparepartCanvas) {
            return; // Tidak ada canvas yang diperlukan
        }

        attachLivewireListeners();

        // Hanya render chart jika canvas ada
        const statusChartPembayaranData = @json($chartStatusPembayaran ?? null);
        if (statusCanvas && statusChartPembayaranData) {
            renderStatusPembayaranChart(statusChartPembayaranData);
        }

        const sparepartChartData = @json($chartJumlahSparepart ?? null);
        if (sparepartCanvas && sparepartChartData) {
            renderSparepartChart(sparepartChartData);
        }

        chartInitialized = true;
    }

    if (document.readyState === 'complete') {
        initializeChart();
    } else {
        document.addEventListener('DOMContentLoaded', initializeChart);
    }

    document.addEventListener('livewire:navigated', () => {
        chartInitialized = false;
        statusPembayaranChartInstance = safeDestroyChart(statusPembayaranChartInstance);
        sparepartChartInstance = safeDestroyChart(sparepartChartInstance);
        livewireListenersAttached = false;

        setTimeout(() => {
            initializeChart();
        }, 100);
    });

    document.addEventListener('livewire:before-unload', () => {
        statusPembayaranChartInstance = safeDestroyChart(statusPembayaranChartInstance);
        sparepartChartInstance = safeDestroyChart(sparepartChartInstance);
        livewireListenersAttached = false;
    });
})();
</script>
@endpush
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

    <div class="row g-3 mb-4" wire:poll.visible.3000ms>
        <div class="col-12 col-lg-4">
            <div class="d-flex h-100 flex-column gap-3 ">
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-money-bill-1-wave"></i> Penjualan Status Pembayaran
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="d-flex justify-content-center p-5 d-flex align-items-center">
                            <canvas id="statusChartPembayaran" wire:ignore.self></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="d-flex flex-column  gap-3">
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-user-tie"></i> Jumlah barang yang terjual
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="d-flex justify-content-center p-5">
                            <canvas id="sparepartChart" wire:ignore.self></canvas>
                        </div>
                    </div>
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
        <div class="col-12 col-md-4 d-flex justify-content-between justify-content-md-end gap-2 mb-2">
            <!-- Checkbox "Semua" -->
            <div class="d-none d-md-flex gap-1">
                <div class="">
                    <input type="checkbox" class="btn-check" id="showAllCheck" wire:model.live="showAll"
                        autocomplete="off">
                    <label class="btn btn-outline-primary mb-0" for="showAllCheck">
                        Semua
                    </label>
                </div>
                <div class="">
                    <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih bulan</option>
                        @foreach(range(1, 12) as $bulan)
                        <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F')
                            }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Tombol Reset -->
                <div class="">
                    <button wire:click="resetFilter" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="fas fa-rotate me-1"></i>
                        <span class="d-none d-md-inline">Reset</span>
                    </button>
                </div>
            </div>
            <div class="row d-md-none g-2 mb-2 w-100">
                <div class="col-6 col-md-3 order-3 order-lg-1">
                    <input type="checkbox" class="btn-check" id="showAllCheck" wire:model.live="showAll"
                        autocomplete="off">
                    <label class="btn btn-outline-primary mb-0" for="showAllCheck">
                        Semua
                    </label>
                </div>
                <div class="col-12 col-md-3 order-1 order-lg-2 w-100">
                    <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih bulan</option>
                        @foreach(range(1, 12) as $bulan)
                        <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F')
                            }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Tombol Reset -->
                <div class="col-6 col-md-3 order-4 order-lg-4 d-flex justify-content-end">
                    <button wire:click="resetFilter" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="fas fa-rotate me-1"></i>
                        <span class="d-none d-md-inline">Reset</span>
                    </button>
                </div>
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
                @can('admin')
                <a class="btn btn-primary float-end" href="{{ route('penjualan.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah Penjualan</span>
                </a>
                @endcan
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
                                <td>{{ number_format($penjualan->diskon, 0, ',', '.') }} %</td>
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
                {{ $penjualans->links() }}
            </div>
        </div>
    </div>

</div>
