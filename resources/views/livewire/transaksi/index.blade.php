@push('scripts')
<script>
    (function () {
        let pendapatanBulananChartInstance = null;
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

        function renderPendapatanBulananChart(chartData) {
            const ctx = document.getElementById('chartPendapatanBulanan');
            if (!ctx) {
                console.warn('Canvas chartPendapatanBulanan tidak ditemukan');
                return;
            }

            if (!chartData || !Array.isArray(chartData.labels) || !Array.isArray(chartData.datasets) || chartData.datasets.length === 0) {
                console.warn('Data chart pendapatan bulanan tidak valid');
                return;
            }

            const datasetsWithColors = chartData.datasets.map(ds => ({
                ...ds,
                backgroundColor: ds.backgroundColor || 'rgba(54, 162, 235, 0.6)',
                borderColor: ds.borderColor || 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: false,
            }));

            // Cek dan update chart jika sudah ada
            if (pendapatanBulananChartInstance) {
                pendapatanBulananChartInstance.data.labels = chartData.labels;
                pendapatanBulananChartInstance.data.datasets = datasetsWithColors;
                pendapatanBulananChartInstance.update();
                console.log("Chart diupdate");
            } else {
                pendapatanBulananChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: datasetsWithColors
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const value = context.parsed.y ?? 0;
                                        return `${context.dataset.label}: Rp ${value.toLocaleString()}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            },
                            y: {
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
                console.log("Chart berhasil dibuat");
            }

            chartInitialized = true;
        }

        function attachLivewireListeners() {
            if (!window.Livewire) return;
            Livewire.on('chart-pendapatan-updated', (data) => {
                renderPendapatanBulananChart(data);
            });
        }

        function initializeChart() {
            if (chartInitialized) return;

            if (window.Livewire) {
                attachLivewireListeners();
            } else {
                document.addEventListener('livewire:load', attachLivewireListeners);
            }

            renderPendapatanBulananChart(@json($chartPendapatanBulanan));
        }

        // Inisialisasi saat DOM pertama kali siap
        document.addEventListener('DOMContentLoaded', initializeChart);

        // Bersihkan chart sebelum navigasi Livewire
        document.addEventListener('livewire:before-unload', () => {
            pendapatanBulananChartInstance = safeDestroyChart(pendapatanBulananChartInstance);
            chartInitialized = false;
        });

        // Inisialisasi ulang setelah navigasi Livewire
        document.addEventListener('livewire:navigated', () => {
            pendapatanBulananChartInstance = safeDestroyChart(pendapatanBulananChartInstance);
            chartInitialized = false;

            setTimeout(() => {
                if (document.getElementById('chartPendapatanBulanan')) {
                    initializeChart();
                }
            });
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

    <div class="row g-3 mb-4" wire:poll.visible.3000ms>
        {{-- 🔸 Kolom Kiri: Ringkasan Pendapatan dan Transaksi --}}
        <div class="col-12 col-lg-4">
            <div class="d-flex flex-column h-100 gap-3">

                {{-- 🔹 Total Pendapatan + Per Jenis --}}
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <div class="mb-3">
                            <div class="text-success mb-2">
                                <i class="fa-solid fa-money-bill-1-wave fa-2x"></i>
                            </div>
                            <h6 class="mb-1 text-muted">Total Pendapatan</h6>
                            <hr class="my-1 border-success opacity-50 mx-auto" style="width: 60%;">
                        </div>

                        <h3 class="fw-bold text-dark mb-4">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </h3>

                        <div class="d-flex justify-content-center gap-4 mb-3">
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

                {{-- 🔹 Jumlah Transaksi --}}
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body d-flex flex-column justify-content-center text-center">
                        <div class="mb-3">
                            <div class="text-primary mb-2">
                                <i class="fa-solid fa-file-invoice-dollar fa-2x"></i>
                            </div>
                            <h6 class="mb-1 text-muted">Jumlah Transaksi</h6>
                            <hr class="my-1 border-primary opacity-50 mx-auto" style="width: 60%;">
                        </div>

                        <h3 class="fw-bold text-dark mb-4">
                            {{ $jumlahTransaksi['total'] }} transaksi
                        </h3>

                        <div class="d-flex justify-content-center gap-4">
                            <div>
                                <small class="text-muted">Service</small><br>
                                <span class="fw-bold">{{ $jumlahTransaksi['service'] }}</span>
                            </div>
                            <div>
                                <small class="text-muted">Penjualan</small><br>
                                <span class="fw-bold">{{ $jumlahTransaksi['penjualan'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        {{-- 🔸 Kolom Kanan: Chart Pendapatan Bulanan --}}
        <div class="col-12 col-lg-8">
            <div class="card card-jumlah h-100 card-hover">
                <div class="card-body">
                    <h5 class="card-title text-success">
                        <i class="fa-solid fa-comments-dollar"></i> Pendapatan Bulanan
                    </h5>
                    <hr class="border border-2 opacity-50">
                    <div class="d-flex justify-content-center p-5" wire:ignore>
                        <canvas id="chartPendapatanBulanan" style="width: 100%; height: 50%; display: block;"
                            width="800px" height="400px"></canvas>
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
        <div class="col-12 col-md-3 d-flex justify-content-between justify-content-md-end gap-2 mb-2">
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
</div>
