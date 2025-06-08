@push('scripts')
<script>
    (function () {
        let pendapatanBulananChartInstance = null;
        let jumlahTransaksiChartInstance = null;
        let chartInitialized = false;
        let livewireListenersAttached = false;

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

        function renderPendapatanBulananChart(chartData) {
            const ctx = document.getElementById('chartPendapatanBulanan');
            if (!ctx) {
                console.warn('Canvas chartPendapatanBulanan tidak ditemukan');
                return;
            }

            // Normalisasi data jika nested
            if (chartData && chartData.chartData) {
                chartData = chartData.chartData;
            }

            // Persiapkan datasets dengan default values
            const preparedDatasets = chartData.datasets.map(ds => ({
                ...ds,
                backgroundColor: ds.backgroundColor || 'rgba(54, 162, 235, 0.6)',
                borderColor: ds.borderColor || 'rgba(128, 128, 128, 0.5)',
                borderWidth: ds.borderWidth ?? 1,
                fill: ds.fill ?? false,
                type: ds.type || 'bar',
                stack: ds.type === 'line' ? undefined : (ds.stack || 'pendapatan'),
                tension: ds.tension ?? (ds.type === 'line' ? 0.3 : 0),
                pointRadius: ds.pointRadius ?? (ds.type === 'line' ? 4 : 3),
                pointHoverRadius: ds.pointHoverRadius ?? (ds.type === 'line' ? 6 : 5)
            }));

            const existingChart = Chart.getChart(ctx);

            if (existingChart) {
                // Update yang lebih aman dengan mempertahankan referensi asli
                existingChart.data.labels = chartData.labels;

                // Update datasets dengan mempertahankan objek asli jika mungkin
                chartData.datasets.forEach((newDataset, i) => {
                    if (existingChart.data.datasets[i]) {
                        // Update properti yang ada
                        Object.assign(existingChart.data.datasets[i], {
                            label: newDataset.label,
                            data: newDataset.data,
                            type: newDataset.type || 'bar',
                            stack: newDataset.type === 'line' ? undefined : (newDataset.stack || 'pendapatan'),
                            backgroundColor: newDataset.backgroundColor || existingChart.data.datasets[i].backgroundColor,
                            borderColor: newDataset.borderColor || existingChart.data.datasets[i].borderColor
                        });
                    } else {
                        // Tambahkan dataset baru jika diperlukan
                        existingChart.data.datasets.push(preparedDatasets[i]);
                    }
                });

                // Hapus dataset yang tidak diperlukan
                if (existingChart.data.datasets.length > chartData.datasets.length) {
                    existingChart.data.datasets.splice(chartData.datasets.length);
                }

                // Update options stacking
                existingChart.options.scales.x.stacked = preparedDatasets.some(ds => ds.stack);
                existingChart.options.scales.y.stacked = preparedDatasets.some(ds => ds.stack);

                existingChart.update();
            } else {
                // Buat chart baru jika belum ada
                if (typeof pendapatanBulananChartInstance !== 'undefined' && pendapatanBulananChartInstance) {
                    pendapatanBulananChartInstance.destroy();
                }

                pendapatanBulananChartInstance = new Chart(ctx, {
                    type: 'bar', // tipe dasar chart
                    data: {
                        labels: chartData.labels,
                        datasets: preparedDatasets
                    },
                    options: {
                        responsive: true, // Ubah ke true untuk better UX
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 20,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const value = context.parsed.y ?? 0;
                                        const label = context.dataset.label;

                                        if (context.dataset.type === 'line') {
                                            return `${label}: Rp ${value.toLocaleString()}`;
                                        }

                                        const total = context.chart.data.datasets
                                            .filter(ds => ds.type !== 'line')
                                            .reduce((sum, ds) => sum + (ds.data[context.dataIndex] || 0), 0);

                                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                        return `${label}: Rp ${value.toLocaleString()} (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: preparedDatasets.some(ds => ds.stack),
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            },
                            y: {
                                stacked: preparedDatasets.some(ds => ds.stack),
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Pendapatan (Rp)'
                                },
                                ticks: {
                                    callback: function (value) {
                                        return 'Rp ' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }


        function renderJumlahTransaksiChart(chartData) {
            const ctx = document.getElementById('chartJumlahTransaksi');
            if (!ctx) {
                console.warn('Canvas chartJumlahTransaksi tidak ditemukan');
                return;
            }

            if (
                !chartData ||
                !Array.isArray(chartData.labels) ||
                !Array.isArray(chartData.datasets) ||
                chartData.datasets.length === 0 ||
                !Array.isArray(chartData.datasets[0].data)
            ) {
                console.warn('Data chart jumlah transaksi tidak valid');
                return;
            }

            const backgroundColors = ['#4e73df', '#1cc88a'];
            const borderColors = ['#2e59d9', '#17a673'];

            // Sisipkan warna ke dataset jika belum ada
            const dataset = {
                ...chartData.datasets[0],
                backgroundColor: chartData.datasets[0].backgroundColor ?? backgroundColors,
                borderColor: chartData.datasets[0].borderColor ?? borderColors,
                borderWidth: chartData.datasets[0].borderWidth ?? 0
            };
            const existingChart = Chart.getChart(ctx);
            if (existingChart) {
                existingChart.data.labels = chartData.labels;
                existingChart.data.datasets[0].data = dataset.data;
                existingChart.data.datasets[0].backgroundColor = dataset.backgroundColor;
                existingChart.data.datasets[0].borderColor = dataset.borderColor;
                existingChart.update();
                jumlahTransaksiChartInstance = existingChart;
            } else {
                if (typeof jumlahTransaksiChartInstance !== 'undefined' && jumlahTransaksiChartInstance) {
                    jumlahTransaksiChartInstance.destroy();
                }

                jumlahTransaksiChartInstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: chartData.labels,
                        datasets: [dataset]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 20,
                                }
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
                        },
                        animation: {
                            animateRotate: true,    // Aktifkan rotasi
                            animateScale: false,     // Aktifkan scaling
                            duration: 1000,         // Durasi animasi (ms)
                            easing: 'easeOutQuart'
                        },
                    }
                });
            }
        }


        function attachLivewireListeners() {
            if (livewireListenersAttached || !window.Livewire) return;

            Livewire.on('chart-pendapatan-updated', (event) => {
                const data = event?.chartData ?? event;
                renderPendapatanBulananChart(data);
            });

            Livewire.on('chart-jumlah-transaksi-updated', (event) => {
                const data = event?.chartData ?? event;
                renderJumlahTransaksiChart(data);
            });

            livewireListenersAttached = true;
        }

        function initializeChart() {
            if (chartInitialized) return;

            attachLivewireListeners();

            const pendapatanCanvas = document.getElementById('chartPendapatanBulanan');
            const transaksiCanvas = document.getElementById('chartJumlahTransaksi');

            const pendapatanChartData = @json($chartPendapatanBulanan ?? null);
            const transaksiChartData = @json($chartJumlahTransaksi ?? null);

            if (pendapatanCanvas && pendapatanChartData) {
                renderPendapatanBulananChart(pendapatanChartData);
            } else if (!pendapatanCanvas) {
                console.log('Canvas chartPendapatanBulanan tidak ditemukan.');
            } else {
                console.warn('Data chart pendapatan bulanan kosong atau null.');
            }

            if (transaksiCanvas && transaksiChartData) {
                renderJumlahTransaksiChart(transaksiChartData);
            } else if (!transaksiCanvas) {
                console.log('Canvas chartJumlahTransaksi tidak ditemukan.');
            } else {
                console.warn('Data chart jumlah transaksi kosong atau null.');
            }

            chartInitialized = true;
        }


        document.addEventListener('livewire:navigated', () => {
            chartInitialized = false;
            livewireListenersAttached = false;

            setTimeout(() => {
                if (document.getElementById('chartPendapatanBulanan')) {
                    initializeChart();
                }
            }, 100);
        },{ once: true });

        if (document.readyState === 'complete') {
            initializeChart();
        } else {
            document.addEventListener('DOMContentLoaded', initializeChart);
        }

        document.addEventListener('livewire:before-unload', () => {
            pendapatanBulananChartInstance = safeDestroyChart(pendapatanBulananChartInstance);
            jumlahTransaksiChartInstance = safeDestroyChart(jumlahTransaksiChartInstance);
            livewireListenersAttached = false;
        });
    })();
</script>
@endpush

<div>
    <h2 class="mt-4">Manajemen Transaksi</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Transaksi</a></li>
        <li class="breadcrumb-item active">Daftar Transaksi</li>
    </ol>

    <div class="row g-3 mb-4" wire:poll.visible.3000ms='emitChartData'>
        {{-- 🔸 Kolom Kiri: Ringkasan Pendapatan dan Transaksi --}}
        <div class="col-12 col-lg-4">
            <div class="d-flex flex-column gap-3">

                {{-- 🔹 Jumlah Transaksi --}}
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-file-invoice-dollar"></i> Jumlah Transaksi
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="d-flex justify-content-center p-3">
                                <canvas id="chartJumlahTransaksi" wire:ignore></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- 🔹 Total Pendapatan + Per Jenis --}}
                <div class="card shadow-sm card-hover" wire:poll.visible.3000ms>
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <div class="mb-3">
                            <div class="text-success mb-2">
                                <i class="fa-solid fa-money-bill-1-wave fa-2x"></i>
                            </div>
                            <h6 class="mb-1 text-muted fs-4">Total Pendapatan</h6>
                            <hr class="my-1 border-success opacity-50 mx-auto" style="width: 60%;">
                        </div>

                        <h3 class="fw-bold text-dark mb-3">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </h3>

                        <div class="d-flex justify-content-center gap-4 mb-2">
                            <div>
                                <small class="text-muted">Total Bayar</small><br>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($statPembayaran['total_bayar'], 0, ',', '.') }}
                                </span>
                            </div>
                            <div>
                                <small class="text-muted">Pending</small><br>
                                <span class="fw-bold text-warning">
                                    Rp {{ number_format($statPembayaran['pending'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-4">
                            <div>
                                <small class="text-muted">Service</small><br>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($pendapatanPerJenis['service'], 0, ',', '.') }}
                                </span>
                            </div>
                            <div>
                                <small class="text-muted">Penjualan</small><br>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($pendapatanPerJenis['penjualan'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>


        {{-- 🔸 Kolom Kanan: Chart Pendapatan Bulanan --}}
        <div class="col-12 col-lg-8 ">
            <div class="card card-jumlah h-100 card-hover d-none d-lg-block">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fa-solid fa-comments-dollar"></i> Pendapatan Bulanan
                    </h5>
                    <hr class="border border-2 opacity-50">
                    <div class="d-flex justify-content-center p-md-5 align-items-center">
                        <canvas id="chartPendapatanBulanan" wire:ignore></canvas>
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


        <div class="col-12 col-md-4 d-flex justify-content-between justify-content-md-end gap-2 mb-2">
            <!-- Checkbox "Semua" -->
            <div class="d-none d-md-flex gap-1">
                <div class="">
                    <input type="checkbox" class="btn-check" id="showAllCheck" wire:model.live="showAll" autocomplete="off">
                    <label class="btn btn-outline-primary mb-0" for="showAllCheck">
                        Semua
                    </label>
                </div>
                <div class="">
                    <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih bulan</option>
                        @foreach(range(1, 12) as $bulan)
                        <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="">
                    <select class="form-select" wire:model.live="jenis_transaksi" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih jenis</option>
                        <option value="service">Service</option>
                        <option value="penjualan">Penjualan</option>
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
                <div class="col-6 col-md-3 order-1 order-lg-2">
                    <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih bulan</option>
                        @foreach(range(1, 12) as $bulan)
                        <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F')
                            }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-3 order-2 order-lg-3">
                    <select class="form-select" wire:model.live="jenis_transaksi" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih jenis</option>
                        <option value="service">Service</option>
                        <option value="penjualan">Penjualan</option>
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
</div>
