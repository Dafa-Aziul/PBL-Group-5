@push('scripts')
<script>
    (function() {
        let myChartInstance = null;
        let statusChartInstance = null;
        let chartInitialized = false;
        let livewireListenersAttached = false;

        function safeDestroyChart(instance) {
            if (instance) {
                try {
                    instance.destroy();
                } catch (e) {
                    console.warn('Gagal menghancurkan chart:', e);
                }
                instance = null;
            }
            return instance;
        }

        function renderChart(chartData) {
            const ctx = document.getElementById('myChart');
            if (!ctx) {
                console.warn('Canvas myChart tidak ditemukan');
                return;
            }

            if (chartData && chartData.chartData) {
                chartData = chartData.chartData;
            }

            const defaultEmptyData = {
                labels: ['Tidak ada data'],
                data: [1],
                backgroundColor: ['#CCCCCC']
            };

            if (!chartData || !Array.isArray(chartData.labels) || !Array.isArray(chartData.data) || chartData.data.length === 0) {
                console.warn('Data kosong, menampilkan chart default');
                chartData = defaultEmptyData;
            } else {
                const statusColors = {
                    'Hadir': '#4BC0C0',
                    'Terlambat': '#FFCE56',
                    'Izin': '#36A2EB',
                    'Alpha': '#FF6384',
                    'Sakit': '#9966FF',
                    'Lembur': '#FF9F40'
                };
                chartData.backgroundColor = chartData.labels.map(label => statusColors[label] || '#CCCCCC');
            }

            const existingChart = Chart.getChart(ctx);

            if (existingChart) {
                existingChart.data.labels = chartData.labels;
                existingChart.data.datasets[0].data = chartData.data;
                existingChart.data.datasets[0].backgroundColor = chartData.backgroundColor;
                existingChart.update();
                myChartInstance = existingChart;
            } else {
                myChartInstance = safeDestroyChart(myChartInstance);

                myChartInstance = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Status Absensi',
                            data: chartData.data,
                            backgroundColor: chartData.backgroundColor,
                            borderWidth: 1,
                            hoverOffset: 10
                        }]
                    },
                    options:{
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 20,
                                    font: {
                                        family: 'system-ui, -apple-system, sans-serif'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        try {
                                            const data = context?.dataset?.data;
                                            const total = Array.isArray(data) ? data.reduce((a, b) => a + b, 0) : 0;
                                            const value = context.raw ?? 0;
                                            const label = context.label ?? 'Tidak diketahui';
                                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;

                                            if (label === 'Tidak ada data') {
                                                return 'Tidak ada data absensi';
                                            }
                                            return `${label}: ${value} (${percentage}%)`;
                                        } catch (e) {
                                            console.warn('Tooltip error:', e);
                                            return 'Data tidak tersedia';
                                        }
                                    }
                                }
                            }
                        },
                        cutout: '65%',
                        animation: {
                            animationRotate: true,
                            animationScale: false,
                        },
                    }
                });
            }
        }

        function renderStatusChart(chartStatus) {
            const ctx = document.getElementById('statusChart');
            if (!ctx) {
                console.warn('Canvas statusChart tidak ditemukan');
                return;
            }

            if (!chartStatus || !Array.isArray(chartStatus.labels) || !Array.isArray(chartStatus.datasets) || chartStatus.datasets.length === 0) {
                console.warn('Data kosong untuk statusChart, tidak dapat menampilkan');
                return;
            }

            // Warna status sesuai label dataset
            const statusColors = {
                'Hadir': '#4BC0C0',
                'Terlambat': '#FFCE56',
                'Izin': '#36A2EB',
                'Alpha': '#FF6384',
                'Sakit': '#9966FF',
                'Lembur': '#FF9F40'
            };

            // Tambahkan warna ke setiap dataset
            const datasetsWithColor = chartStatus.datasets.map(ds => ({
                ...ds,
                backgroundColor: statusColors[ds.label] || '#CCCCCC',
                borderWidth: 1,
            }));

            const existingChart = Chart.getChart(ctx);

            if (existingChart) {
                // Update labels
                existingChart.data.labels = chartStatus.labels;

                // Update datasets dengan mempertahankan referensi asli
                chartStatus.datasets.forEach((newDataset, index) => {
                    if (existingChart.data.datasets[index]) {
                        // Update properti dataset yang ada
                        const existingDataset = existingChart.data.datasets[index];
                        existingDataset.label = newDataset.label;
                        existingDataset.data = newDataset.data;
                        existingDataset.backgroundColor = statusColors[newDataset.label] || '#CCCCCC';
                    } else {
                        // Tambahkan dataset baru jika diperlukan
                        existingChart.data.datasets.push({
                            ...newDataset,
                            backgroundColor: statusColors[newDataset.label] || '#CCCCCC',
                            borderWidth: 1
                        });
                    }
                });

                // Hapus dataset yang tidak ada lagi
                while (existingChart.data.datasets.length > chartStatus.datasets.length) {
                    existingChart.data.datasets.pop();
                }

                existingChart.update();
            } else {
                // Pastikan jika sebelumnya ada chart, dihancurkan dulu
                if (typeof statusChartInstance !== 'undefined' && statusChartInstance) {
                    statusChartInstance.destroy();
                }

                statusChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartStatus.labels,
                        datasets: datasetsWithColor,
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.parsed.y || 0;
                                        return `${label}: ${value}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 45,
                                    minRotation: 45,
                                }
                            },
                            y: {
                                stacked: true,
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
            if (livewireListenersAttached || !window.Livewire) return;

            Livewire.on('chart-updated', (event) => {
                const data = event?.chartData ?? event;
                renderChart(data);
            });

            // Listener untuk chart status (bar chart kehadiran, dsb)
            Livewire.on('chart-bar-updated', (event) => {
                const statusData = event?.chartStatus ?? event;
                renderStatusChart(statusData); // Panggil fungsi khusus chart status
            });

            livewireListenersAttached = true;
        }

        function initializeChart() {
            if (chartInitialized) return;

            if (window.Livewire) {
                attachLivewireListeners();
            } else {
                document.addEventListener('livewire:load', attachLivewireListeners);
            }

            renderChart(@json($chartData));
            renderStatusChart(@json($chartStatus)); // pastikan ini kamu passing dari backend

            chartInitialized = true;
        }

        document.addEventListener('livewire:navigated', () => {
            chartInitialized = false;
            livewireListenersAttached = false;

            setTimeout(() => {
                if (document.getElementById('myChart')) {
                    initializeChart();
                }
            },100);
        });

        if (document.readyState === 'complete') {
            initializeChart();
        } else {
            document.addEventListener('DOMContentLoaded', initializeChart);
        }

        document.addEventListener('livewire:before-unload', () => {
            myChartInstance = safeDestroyChart(myChartInstance);
            statusChartInstance = safeDestroyChart(statusChartInstance);
            livewireListenersAttached = false;
        });
    })();
</script>
@endpush
<div>
    <div class="">
        <h2 class="mt-4">Kelola Absensi</h2>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                    href="{{ route('absensi.view') }}">Absensi</a></li>
            <li class="breadcrumb-item active">Rekap Absensi</li>
        </ol>
    </div>

    {{-- Perbaikan session flash message --}}
    @if (session()->has('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session()->has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="row g-3 mb-4" wire:poll.visible.3000ms='emitChartData'>
        <div class="col-12 col-lg-4">
            <div class="d-flex h-100 flex-column gap-3 ">
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-money-bill-1-wave"></i> Penjualan Status Pembayaran
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="d-flex justify-content-center p-5 d-flex align-items-center">
                            <canvas id="myChart" wire:ignore></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="d-flex flex-column h-100 gap-3">
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-user-tie"></i> Rekap Absen Karyawan
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="d-flex justify-content-center p-5">
                            <canvas id="statusChart" wire:ignore></canvas>
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
                    <input type="date" id="tanggalAwal" wire:model="tanggalAwal" class="form-control" @if ($filterBulan) disabled @endif>
                </div>

                <!-- To -->
                <div class="d-flex align-items-center gap-2 me-md-4 mb-2 mb-md-0">
                    <label for="tanggalAkhir" class="form-label mb-0" style="width: 50px;">To :</label>
                    <input type="date" id="tanggalAkhir" wire:model.lazy="tanggalAkhir" class="form-control" @if ($filterBulan) disabled @endif>
                </div>

            </div>
        </div>


        <!-- Reset Button -->
        <div class="col-12 col-md-4 d-flex justify-content-between justify-content-md-end gap-2 mb-2">
            <!-- Checkbox "Semua" -->
            <div>
                <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;" @if($tanggalAwal) disabled @endif>
                    <option value="" disabled selected hidden>Pilih Bulan</option>
                    @foreach(range(1, 12) as $bulan)
                    <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="form-select" wire:model.change="filterStatus" style="cursor:pointer;">
                    <option value="" disabled selected hidden>Pilih Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="terlambat">Terlambat</option>
                    <option value="lembur">Lembur</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>
            <div>
                <select class="form-select" wire:model.change="sortDirection">
                    <option value="desc">Terbaru</option>
                    <option value="asc">Terlama</option>
                </select>
            </div>
            <div class="">
                <button wire:click="resetFilters" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="fas fa-rotate me-1"></i>
                    <span class="d-none d-md-inline">Reset</span>
                </button>
            </div>
        </div>


    </div>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="ms-1 semibold">Rekap Absensi</span>
            </div>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary" title="Export data" data-bs-toggle="modal"
                    data-bs-target="#exportModal">
                    Export <i class="fa-solid fa-file-export ms-1"></i>
                </button>
            </div>
            <div wire:ignore.self class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form wire:submit.prevent="submitForm" class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Export Laporan Absensi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            {{-- Start Date --}}
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="startDate" wire:model="start_date">
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- End Date --}}
                            <div class="mb-3">
                                <label for="endDate" class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="endDate" wire:model="end_date">
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Format --}}
                            <div class="mb-3">
                                <label class="form-label">Format Export</label>
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" id="formatPdf" wire:model="format"
                                        value="pdf">
                                    <label class="btn btn-outline-danger" for="formatPdf">
                                        <i class="fa-solid fa-file-pdf me-1"></i> PDF
                                    </label>
                                </div>
                                @error('format')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-download me-1"></i> Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3 align-items-center">
                <!-- Select Entries per page -->
                <div class="col-auto d-flex align-items-center">
                    <select class="form-select form-select" wire:model.live="perPage"
                        style="width:auto; cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label class="d-none d-md-inline ms-2 mb-0 text-muted">Entries per page</label>
                </div>

                <!-- Search -->
                <div class="col-6 ms-auto col-md-4">
                    <div class="position-relative">
                        <input type="text" class="form-control form-control ps-5" placeholder="Search"
                            wire:model.live.debounce.300ms="search" />
                        <i
                            class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    </div>
                </div>
            </div>

            {{-- Filter Bulan, Minggu, Status, dan Sort Tanggal --}}

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Foto Masuk</th>
                            <th>Foto Keluar</th>
                            <th>Status</th>
                            <th>Keterangan</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($absensis as $absensi)
                        <tr>
                            {{-- Gunakan nomor dengan pagination --}}
                            <td class="text-center">{{ ($absensis->firstItem() + $loop->index) }}</td>

                            {{-- Nama karyawan --}}
                            <td>
                                {{ $absensi->karyawan ? $absensi->karyawan->nama : 'Karyawan tidak ditemukan' }}
                            </td>

                            {{-- Tanggal absensi, format Indonesia --}}
                            <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}</td>

                            {{-- Jam masuk --}}
                            <td>{{ $absensi->jam_masuk ?? '-' }}</td>

                            {{-- Jam keluar --}}
                            <td>{{ $absensi->jam_keluar ?? '-' }}</td>

                            {{-- Foto masuk, dengan fallback default --}}
                            <td class="text-center">
                                <img src="{{ asset(
                                        optional($absensi)?->bukti_tidak_hadir
                                            ? 'storage/absensi/foto_tidak_hadir/' . optional($absensi)->bukti_tidak_hadir
                                            : (optional($absensi)?->foto_masuk
                                                ? 'storage/absensi/foto_masuk/' . optional($absensi)->foto_masuk
                                                : 'images/user/default.jpg')
                                    ) }}"
                                    alt="Foto Absensi" class="img-thumbnail" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                            </td>

                            {{-- Foto keluar, dengan fallback default --}}
                            <td class="text-center">
                                <img src="{{ $absensi->foto_keluar ? asset('storage/absensi/foto_keluar/' . $absensi->foto_keluar) : asset('images/user/default.jpg') }}"
                                    alt="Foto Keluar" class="img-thumbnail"
                                    style="max-width: 100px; max-height: 100px; object-fit: contain;">
                            </td>

                            {{-- Status --}}
                            <td>{{ ucfirst($absensi->status) }}</td>

                            {{-- Keterangan --}}
                            <td>{{ $absensi->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            {{-- colspan disesuaikan dengan jumlah kolom --}}
                            <td colspan="9" class="text-center text-muted">Tidak ada data absensi yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
                {{ $absensis->links() }}
            </div>
        </div>
    </div>
</div>
