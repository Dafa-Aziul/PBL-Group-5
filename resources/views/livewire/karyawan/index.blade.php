@push('scripts')
<script>
    (function () {
        let performanceChartInstance = null;
        let livewireListenersAttached = false;
        let chartInitialized = false;
        const colorMap = {};



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

        function renderPerformanceChart(chartPerformance) {
            const ctx = document.getElementById('performanceChart');
            if (!ctx) return;

            if (
                !chartPerformance ||
                !Array.isArray(chartPerformance.labels) ||
                !Array.isArray(chartPerformance.datasets) ||
                chartPerformance.datasets.length === 0
            ) {
                console.warn('Data kosong untuk performanceChart, tidak dirender');
                performanceChartInstance = safeDestroyChart(performanceChartInstance);
                return;
            }

            function getColorForLabel(label) {
                if (!colorMap[label]) {
                    const r = Math.floor(Math.random() * 255);
                    const g = Math.floor(Math.random() * 255);
                    const b = Math.floor(Math.random() * 255);
                    colorMap[label] = {
                        border: `rgba(${r}, ${g}, ${b}, 1)`,
                        background: `rgba(${r}, ${g}, ${b}, 0.2)`
                    };
                }
                return colorMap[label];
            }

            const datasetsWithColor = chartPerformance.datasets.map(ds => {
                const color = getColorForLabel(ds.label);
                return {
                    ...ds,
                    fill: false,
                    borderColor: color.border,
                    backgroundColor: color.background,
                    tension: 0.1
                };
            });

            // Gunakan Chart.getChart untuk cek apakah chart sudah ada
            const existingChart = Chart.getChart(ctx);

            if (existingChart) {
                // Update chart yang sudah ada tanpa destroy
                existingChart.data.labels = chartPerformance.labels;

                chartPerformance.datasets.forEach((newDataset, index) => {
                    const color = getColorForLabel(newDataset.label);

                    if (existingChart.data.datasets[index]) {
                        const existingDataset = existingChart.data.datasets[index];
                        existingDataset.label = newDataset.label;
                        existingDataset.data = newDataset.data;
                        existingDataset.borderColor = color.border;
                        existingDataset.backgroundColor = color.background;
                    } else {
                        existingChart.data.datasets.push({
                            ...newDataset,
                            borderColor: color.border,
                            backgroundColor: color.background,
                            fill: false,
                            tension: 0.1
                        });
                    }
                });

                // Hapus dataset lebih jika ada
                while (existingChart.data.datasets.length > chartPerformance.datasets.length) {
                    existingChart.data.datasets.pop();
                }

                existingChart.update();
            } else {
                // Hancurkan jika instance lama tersimpan
                performanceChartInstance = safeDestroyChart(performanceChartInstance);

                performanceChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartPerformance.labels,
                        datasets: datasetsWithColor,
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const label = context.dataset.label || '';
                                        const value = context.parsed.y || 0;
                                        return `${label}: ${value}`;
                                    },
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 45,
                                    minRotation: 45,
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

        // Fungsi aman untuk menghancurkan chart
        function safeDestroyChart(chartInstance) {
            if (chartInstance && typeof chartInstance.destroy === 'function') {
                chartInstance.destroy();
            }
            return null;
        }

        function attachLivewireListeners() {
            if (livewireListenersAttached || !window.Livewire) return;

            Livewire.on('chart-updated', (event) => {
                const data = event?.chartPerformance ?? event;
                renderPerformanceChart(data);
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

            renderPerformanceChart(@json($chartPeformance));
            chartInitialized = true;
        }

        document.addEventListener('livewire:navigated', () => {
            chartInitialized = false;
            livewireListenersAttached = false;

            setTimeout(() => {
                if (document.getElementById('performanceChart')) {
                    initializeChart();
                }
            }, 100);
        });

        if (document.readyState === 'complete') {
            initializeChart();
        } else {
            document.addEventListener('DOMContentLoaded', initializeChart);
        }

        document.addEventListener('livewire:before-unload', () => {
            performanceChartInstance = safeDestroyChart(performanceChartInstance);
            livewireListenersAttached = false;
        });
    })();
</script>
@endpush



<div>
    <h2 class="mt-4">Kelola Karyawan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('user.view') }}">Karyawan</a></li>
        <li class="breadcrumb-item active">Daftar Karyawan</li>
    </ol>

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

    @can('owner')
    <div class="d-flex flex-column h-100 gap-3 g-3 mb-4" wire:poll.visible.3000ms='emitChartData'>
        <div class="card card-jumlah flex-fill card-hover">
            <div class="card-body">
                <h5 class="card-title text-success">
                    <i class="fa-solid fas fa-chart-area me-2"></i>Kinerja Karyawan
                </h5>
                <hr class="border border-2 opacity-50">
                <div class="d-flex justify-content-center p-5">
                    <canvas id="performanceChart" wire:ignore></canvas>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="row g-2 d-flex justify-content-between align-items-center mb-2">

        <div class="col-12 col-md-4 d-flex align-items-center gap-3">
            <!-- Container form untuk dari dan sampai -->
            <div class="d-flex flex-column flex-md-row gap-3 w-100">
                <!-- From -->
                <div class="d-flex align-items-center gap-2 me-md-0 mb-2 mb-md-0">
                    <label for="tanggalAwal" class="form-label mb-0" style="width: 50px;">From:</label>
                    <input type="date" id="tanggalAwal" wire:model="tanggalAwal" class="form-control" @if ($filterBulan)
                        disabled @endif>
                </div>

                <!-- To -->
                <div class="d-flex align-items-center gap-2 me-md-4 mb-2 mb-md-0">
                    <label for="tanggalAkhir" class="form-label mb-0" style="width: 50px;">To :</label>
                    <input type="date" id="tanggalAkhir" wire:model.lazy="tanggalAkhir" class="form-control" @if($filterBulan) disabled @endif>
                </div>

            </div>
        </div>


        <!-- Reset Button -->
        <div class="col-12 col-md-4 d-flex justify-content-between justify-content-md-end gap-2 mb-2">
            <!-- Checkbox "Semua" -->
            <div>
                <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;" @if($tanggalAwal)
                    disabled @endif>
                    <option value='' disabled selected hidden>Pilih Bulan</option>
                    @foreach(range(1, 12) as $bulan)
                    <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select class="form-select" wire:model.live.debounce.300ms="filterRole" style="cursor:pointer;">
                    <option value='' disabled selected hidden>Pilih Karyawan</option>
                    <option value="admin">Admin</option>
                    <option value="mekanik">Mekanik</option>
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
                <span class="ms-1">Daftar Karyawan</span>
            </div>
            <div>
                @can('admin')
                <a class="btn btn-primary float-end" href="{{ route('karyawan.create') }}" wire:navigate>
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah karyawan</span>
                </a>
                @endcan
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

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>No Hp</th>
                            <th>Alamat</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Foto</th>
                            @can('admin')
                            <th class="text-center">Aksi</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawans as $karyawan)
                        <tr class="align-middle">
                            {{-- Gunakan nomor dengan pagination --}}
                            <td class="text-center">{{ ($karyawans->firstItem() + $loop->index)}}</td>
                            <!-- <td>{{ $karyawan->user->name }}</td> -->
                            <td>{{ $karyawan->user->name ?? 'Tidak Ada User' }}</td>

                            <td>{{ $karyawan->jabatan }}</td>
                            <td>{{ $karyawan->no_hp }}</td>
                            <td>{{ $karyawan->alamat }}</td>
                            <td>{{ \Carbon\Carbon::parse($karyawan->tgl_masuk)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                @if ($karyawan->status === 'aktif')
                                <span class="badge bg-success px-3 py-1  fw-semibold">Aktif</span>
                                @else
                                <span class="badge bg-secondary px-3 py-1 fw-semibold">Tidak Aktif</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <img src="{{ $karyawan->foto ? asset('storage/images/profile/' . $karyawan->foto) : asset('storage/foto/default.png') }}"
                                    alt="Foto Karyawan" width="80" height="80" class="rounded-circle">
                            </td>
                            @can('admin')
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('karyawan.edit', ['id' => $karyawan->id]) }}"
                                        class="btn btn-warning btn-sm me-1" wire:navigate>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </a>

                                    {{-- Buat modal delete dengan id unik per karyawan --}}
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirm-{{ $karyawan->id }}">
                                        <i class="fas fa-trash-can"></i>
                                        <span class="d-none d-md-inline ms-1">Delete</span>
                                    </button>
                                    <x-modal.confirm id="confirm-{{ $karyawan->id }}" action="modal"
                                        target="delete({{ $karyawan->id }})"
                                        content="Apakah anda yakin untuk menghapus karyawan ini?" />
                                </div>
                            </td>
                            @endcan
                        </tr>
                        @empty
                        <tr>
                            {{-- colspan disesuaikan dengan jumlah kolom --}}
                            <td colspan="9" class="text-center text-muted">Tidak ada data karyawan yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $karyawans->links() }}
            </div>
        </div>
    </div>
</div>
