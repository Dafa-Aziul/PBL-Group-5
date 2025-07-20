@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('tampilkanModalTransaksi', (serviceId) => {
            console.log('Menerima event tampilkanModalTransaksi:', serviceId); // Debug cek event sampai
            const modalEl = document.getElementById(`modalTransaksi-${serviceId}`);
            if (modalEl) {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            } else {
                console.warn('Modal dengan ID modalTransaksi-' + serviceId + ' tidak ditemukan.');
            }
        });
    });
</script>
<script>
    (function () {
        let statusServiceChartInstance = null;
        let jumlahServiceLineChartInstance = null;
        let chartStatusHandler = null;
        let chartJumlahHandler = null;
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

        function renderStatusServiceChart(chartData) {
            const ctx = document.getElementById('statusServiceChart');
            if (!ctx) return;

            if (!chartData?.labels || !chartData?.datasets?.[0]?.data) {
                console.warn('Data chart tidak valid');
                return;
            }

            const dataset = chartData.datasets[0];
            const existingChart = Chart.getChart(ctx);

            if (existingChart) {
                existingChart.data.labels = chartData.labels;
                existingChart.data.datasets[0].data = dataset.data;
                existingChart.data.datasets[0].backgroundColor = dataset.backgroundColor;
                existingChart.update();
                statusServiceChartInstance = existingChart;
                return;
            }

            statusServiceChartInstance = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        ...dataset,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 20
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
                    }
                }
            });
        }

        function renderJumlahServiceLineChart(chartData) {
            const ctx = document.getElementById('chartJumlahServiceHarian');
            if (!ctx) return;

            if (!chartData?.labels || !chartData?.datasets?.length) {
                console.warn('Data chart jumlah service tidak valid');
                return;
            }

            const existingChart = Chart.getChart(ctx);

            if (existingChart) {
                // Perbaikan 1: Pastikan struktur dataset tetap konsisten
                existingChart.data.labels = chartData.labels;

                // Perbaikan 2: Update properti dataset yang ada daripada mengganti seluruhnya
                // Ini menjaga konfigurasi asli seperti warna, fill, dll.
                chartData.datasets.forEach((newDataset, i) => {
                    if (existingChart.data.datasets[i]) {
                        // Update hanya data dan label, pertahankan properti lainnya
                        existingChart.data.datasets[i].data = newDataset.data;
                        existingChart.data.datasets[i].label = newDataset.label;
                    } else {
                        // Jika dataset baru tidak ada di chart yang ada, tambahkan
                        existingChart.data.datasets.push(newDataset);
                    }
                });

                // Perbaikan 3: Hapus dataset yang tidak ada di data baru
                while (existingChart.data.datasets.length > chartData.datasets.length) {
                    existingChart.data.datasets.pop();
                }

                existingChart.update();
                return;
            }

            // Jika chart belum ada, buat baru
            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        intersect: false
                    },
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Jumlah Service'
                            },
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                stepSize: 1 // Pastikan selalu menampilkan bilangan bulat
                            }
                        }
                    }
                }
            });
        }


        function initialize() {
            if (chartInitialized) return;

            // Setup listeners Livewire untuk chart-status dan chart-jumlah
            chartStatusHandler = (event) => {
                renderStatusServiceChart(event?.chartData ?? event);
            };
            chartJumlahHandler = (event) => {
                renderJumlahServiceLineChart(event?.chartData ?? event);
            };

            if (window.Livewire) {
                Livewire.on('chart-status-updated', chartStatusHandler);
                Livewire.on('chart-jumlah-service-updated', chartJumlahHandler);
            }

            // Initial render
            const chartStatusData = @json($chartStatusService ?? null);
            if (chartStatusData) {
                renderStatusServiceChart(chartStatusData);
            }

            const chartJumlahData = @json($chartJumlahService ?? null);
            if (chartJumlahData) {
                renderJumlahServiceLineChart(chartJumlahData);
            }

            chartInitialized = true;
        }

        // First load
        if (document.readyState === 'complete') {
            initialize();
        } else {
            document.addEventListener('DOMContentLoaded', initialize);
        }

        // Livewire navigation
        document.addEventListener('livewire:navigated', () => {
            setTimeout(initialize, 300); // Lebih lama untuk memastikan DOM siap
        });
    })();
</script>
@endpush

<div>
    <h2 class="mt-4">Manajemen Service</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('service.view') }}">service</a></li>
        <li class="breadcrumb-item active">Daftar service</li>
    </ol>
    @if (session()->has('success'))
    <div class="        ">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
    @elseif (session()->has('error'))
    <div class="        ">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
    @endif

    <div class="row g-3 mb-4" wire:poll.visible.3000ms>
        {{-- 🔸 Kolom Kiri: Ringkasan Pendapatan dan Transaksi --}}
        <div class="col-12 col-lg-4">
            <div class="d-flex h-100 flex-column gap-3 ">
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-money-bill-1-wave"></i> Penjualan Status Pembayaran
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="d-flex justify-content-center p-5 d-flex align-items-center">
                            <canvas id="statusServiceChart" wire:ignore></canvas>
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
                        <canvas id="chartJumlahServiceHarian" wire:ignore></canvas>
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
                <div class="d-flex align-items-center gap-2 me-md-4 mb-2 mb-md-0">
                    <label for="tanggalAwal" class="form-label mb-0" style="width: 50px;">From:</label>
                    <input type="date" id="tanggalAwal" wire:model="tanggalAwal" class="form-control" @if($showAll)
                        disabled @endif @if ($filterBulan) disabled @endif>
                </div>

                <!-- To -->
                <div class="d-flex align-items-center gap-2 me-md-4 mb-2 mb-md-0">
                    <label for="tanggalAkhir" class="form-label mb-0" style="width: 50px;">To :</label>
                    <input type="date" id="tanggalAkhir" wire:model.live="tanggalAkhir" class="form-control"
                        @if($showAll) disabled @endif @if ($filterBulan) disabled @endif>
                </div>

            </div>
        </div>


        <!-- Reset Button -->
        <div class="col-12 col-md-4 d-flex justify-content-between justify-content-md-end gap-2 mb-2">
            <!-- Checkbox "Semua" -->
            <div class="d-none d-md-flex gap-1">
                <div class="">
                    <input type="checkbox" class="btn-check" id="showAllCheck" wire:model.live="showAll"
                        autocomplete="off" @if($tanggalAwal || $tanggalAkhir) disabled @endif @if ($filterBulan) disabled @endif>
                    <label class="btn btn-outline-primary mb-0" for="showAllCheck">
                        Semua
                    </label>
                </div>
                <div class="w-100">
                    <select class="form-select" wire:model.live="status" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih Status</option>
                        <option value="dalam antrian">dalam antarian</option>
                        <option value="dianalisis">dianalisis</option>
                        <option value="analisis selesai">analisis selesai</option>
                        <option value="dalam proses">dalam proses</option>
                        <option value="selesai">selesai</option>
                        <option value="batal">batal</option>
                    </select>
                </div>
                <div class="w-100">
                    <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;" @if($showAll)
                        disabled @endif @if($tanggalAwal || $tanggalAkhir) disabled @endif>
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
                <div class="col-6 col-md-3 order-1 order-lg-2">
                    <select class="form-select" wire:model.live="status" style="cursor:pointer;">
                        <option value="" disabled selected hidden class="text-muted">Pilih Status</option>
                        <option value="dalam antrian">dalam antarian</option>
                        <option value="dianalisis">dianalisis</option>
                        <option value="analisis selesai">analisis selesai</option>
                        <option value="dalam proses">dalam proses</option>
                        <option value="selesai">selesai</option>
                        <option value="batal">batal</option>
                    </select>
                </div>
                <div class="col-6 col-md-3 order-1 order-lg-2">
                    <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;" @if($showAll)
                        disabled @endif>
                        <option value="" disabled selected hidden class="text-muted">Pilih Bulan</option>
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
                <span class="ms-1">Daftar service</span>
            </div>
            <div>
                @can('admin')
                <a class="btn btn-primary float-end" href="{{ route('service.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah service</span>
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

            <div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr class="align-middle">
                                <th>No.</th>
                                <th>Kode service</th>
                                <th>Pelanggan</th>
                                <th>Nomor Polisi</th>
                                <th>Tipe Kendaraan</th>
                                <th>Status Service</th>
                                <th>Montir</th>
                                <th>Tanggal Mulai</th>
                                <th>tanggal Selesai</th>
                                <th>keterangan</th>
                                @can('admin')
                                <th>Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        </tfoot>
                        <tbody>
                            @forelse ($services as $service)
                            <tr style="cursor:pointer;" x-data @click="Livewire.navigate(`/service/{{ $service->id }}`)"
                                class="align-middle">
                                <td class="text-center">{{ ($services->firstItem() + $loop->iteration) - 1 }}</td>
                                <td>{{ $service->kode_service }}</td>
                                <td>{{ $service->kendaraan->pelanggan->nama }}</td>
                                <td>{{ $service->no_polisi }}</td>
                                <td>{{ $service->tipe_kendaraan }}</td>
                                <td @click.stop class="text-center">
                                    @can('admin')
                                    @if(in_array($service->status, ['selesai', 'batal']))
                                        @if($service->status == 'selesai')
                                            <div class="badge bg-success d-inline-flex align-items-center py-2 px-3 fs-7">
                                                <i class="fas fa-check-circle me-1"></i> Selesai
                                            </div>
                                        @elseif($service->status == 'batal')
                                            <div class="badge bg-danger d-inline-flex align-items-center py-2 px-3 fs-7">
                                                <i class="fas fa-times-circle me-1"></i> Batal
                                            </div>
                                        @endif
                                    @else
                                    <form wire:submit.prevent="updateStatus({{ $service->id }})"
                                        class="d-flex flex-column align-items-start">
                                        <div class="d-flex align-items-center">
                                            <select wire:model="statuses.{{ $service->id }}" class="form-select me-2"
                                                style="width: 160px;">
                                                <option value="dalam antrian">dalam antrian</option>
                                                <option value="dianalisis">dianalisis</option>
                                                <option value="analisis selesai">analisis selesai</option>
                                                <option value="dalam proses">dalam proses</option>
                                                <option value="selesai">selesai</option>
                                                @if ($service->status != 'dalam proses' )
                                                    <option value="batal">batal</option>
                                                @endif
                                            </select>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                        @error('statuses.' . $service->id)
                                        <small x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)"
                                            x-show="show" x-transition:leave.duration.300ms
                                            class="text-danger small mt-1">
                                            {{ $message }}
                                        </small>
                                        @enderror

                                    </form>
                                    <!-- Modal Konfirmasi Transaksi -->
                                    <div wire:ignore.self class="modal fade" id="modalTransaksi-{{ $service->id }}"
                                        tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTransaksiLabel-{{ $service->id }}">
                                                        Konfirmasi Transaksi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Service telah selesai. Apakah Anda ingin melanjutkan ke transaksi
                                                    pembayaran?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Nanti Saja</button>
                                                    <a href="{{ route('transaksi.service', ['id' => $service->id]) }}"
                                                        class="btn btn-primary">Lanjutkan</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endcan

                                    @if (auth()->user()->role != 'admin' && auth()->user()->role != 'superadmin')
                                    @if (in_array($service->status, ['selesai', 'batal']))
                                    <div class="badge bg-secondary d-inline-flex align-items-center py-2 px-3 fs-7">
                                        <i class="fas fa-info-circle me-1"></i> {{ ucfirst($service->status) }}
                                    </div>
                                    @else
                                    <div class="badge bg-warning d-inline-flex align-items-center py-2 px-3 fs-7">
                                        <i class="fas fa-spinner me-1"></i> {{ ucfirst($service->status) }}
                                    </div>
                                    @endif
                                    @endif
                                </td>
                                <td>{{ $service->montir ? $service->montir->nama : 'Belum ditugaskan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($service->tanggal_mulai_service)->translatedFormat('d F Y
                                    H:i') }}</td>
                                <td>{{
                                    $service->status === 'batal'
                                    ? 'Service dibatalkan'
                                    : ($service->tanggal_selesai_service
                                    ? \Carbon\Carbon::parse($service->tanggal_selesai_service)->translatedFormat('d F Y
                                    H:i')
                                    : 'Service belum selesai')
                                    }}
                                </td>
                                <td>{{ $service->keterangan }}</td>
                                @can('admin')
                                <td class="text-center" @click.stop>
                                    @if (!in_array($service->status, ['selesai', 'batal']))
                                    <a href="{{ route('service.edit', ['id' => $service->id]) }}"
                                        class="btn btn-warning mb-3 mb-md-2" wire:navigate>
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </a>
                                    @endif
                                    @if ($service->status == 'analisis selesai' || $service->status == 'dalam proses' )
                                    <a href="{{ route('service.detail', ['id' => $service->id]) }}"
                                        class="btn btn-info mb-3 mb-md-2" wire:navigate>
                                        <i class="fa-solid fa-plus"></i>
                                        <span class="d-none d-md-inline ms-1">detail</span>
                                    </a>
                                    @endif

                                    @if (is_null($service->serviceDetail)&& $service->status == 'selesai')
                                    <a href="{{ route('transaksi.service', ['id' => $service->id]) }}"
                                        class="btn btn-info mb-3 mb-md-2" wire:navigate>
                                        <i class="fa-solid fa-receipt"></i>
                                        <span class="d-none d-md-inline ms-1">Catat Transaksi</span>
                                    </a>
                                    @endif
                                </td>
                                @endcan
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                            </tr>
                            @endforelse
                    </table>
                    {{ $services -> links() }}
                </div>
            </div>
        </div>
    </div>

</div>
