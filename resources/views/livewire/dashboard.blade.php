@php
use Carbon\Carbon;
Carbon::setLocale('id');

$user = auth()->user();
$now = Carbon::now();
$today = $now->toDateString();
$jamSekarang = $now->format('H:i');
$jamPulang = '17:00';

$absenHariIni = $user->karyawan
? $user->karyawan->absensis()->whereDate('tanggal', $today)->first()
: null;

$sudahCheckIn = $absenHariIni && $absenHariIni->jam_masuk;
$sudahCheckOut = $absenHariIni && $absenHariIni->jam_keluar;

$statusText = 'Belum Absen';
if ($sudahCheckIn && !$sudahCheckOut) {
$statusText = 'Kamu sudah Check In';
} elseif ($sudahCheckIn && $sudahCheckOut) {
$statusText = 'Selamat beristirahat!';
}

$statusHariIni = $absenHariIni ? strtolower($absenHariIni->status) : null;
$bolehCheckIn = !in_array($statusHariIni, ['izin', 'sakit']);
@endphp

<div>
    <h1 class="mt-4" style="color: #09005d;">
        Selamat Datang, {{ Auth::user()->name }} 👋
        <label class="text-muted mb-4">{{ Carbon::now()->translatedFormat('l, d F Y') }}</label>
    </h1>

    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>



    <div class="row g-3 d-flex align-items-stretch">
        @can('akses-admin-owner')
        {{-- Bagian Chart Transaksi --}}
        <div class="col-md-9">
            <div class="card card-hover" wire:poll.visible.3000ms='emitChartData'>
                <div class="card-body">
                    <h3 class="card-title text-center text-success">
                        <i class="fa-solid fa-chart-simple"></i> Chart Transaksi
                    </h3>
                    <hr class="border border-2 opacity-50">
                    <canvas id="chartPendapatanBulanan" wire:ignore></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 card-hover">
                <div class="card-body d-flex flex-column" style="height: 100%;">
                    <h5 class="card-title text-success">
                        <i class="fa-solid fa-file-invoice-dollar"></i> Jumlah Transaksi
                    </h5>
                    <hr class="border border-2 opacity-50">
                    <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center">
                        <small class="text-uppercase text-muted mb-1" style="letter-spacing: 1px;">
                            Total Semua Transaksi
                        </small>

                        <h1 class="fw-bold text-dark display-4 mb-2">{{ $jumlahTransaksi }}</h1>

                        <div class="d-flex justify-content-center gap-3 mt-2 flex-wrap">
                            <div
                                class="d-flex align-items-center bg-success-subtle text-success px-3 py-2 rounded shadow-sm">
                                <i class="fas fa-tools fa-lg me-2"></i>
                                <div class="text-start">
                                    <div class="fw-bold">{{ $service }}</div>
                                    <small>Service</small>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-center bg-primary-subtle text-primary px-3 py-2 rounded shadow-sm">
                                <i class="fas fa-shopping-cart fa-lg me-2"></i>
                                <div class="text-start">
                                    <div class="fw-bold">{{ $penjualan }}</div>
                                    <small>Penjualan</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endcan
        {{-- admin-mekanik --}}
        @can('akses-karyawan')
        {{-- Kolom Absen --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="fa-solid fa-clipboard-user"></i> Absen Hari Ini
                    </h3>
                    <hr class="border border-2 opacity-50">
                    <h4 class="text-center my-5 fw-bold">{{ $statusText }}</h4>

                    @if ($user && $user->karyawan)
                    {{-- Check In --}}
                    @if (!$sudahCheckIn)
                    @if ($jamSekarang < $jamPulang) <div class="text-center">
                        <a class="btn btn-absen btn-sm mt-3 float {{ $bolehCheckIn ? '' : 'disabled' }}"
                            href="{{ $bolehCheckIn ? route('absensi.create', ['id' => $user->karyawan->id, 'type' => 'check-in']) : '#' }}"
                            wire:navigate @if (!$bolehCheckIn) aria-disabled="true" tabindex="-1" @endif>
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline ms-1">Check In</span>
                        </a>

                        @else
                        <div class="alert alert-warning text-center mt-3">
                            Anda sudah melewati jam pulang, status Anda alpha.
                        </div>
                        @endif
                        @else
                        {{-- Sudah Check In --}}
                        <div class="text-center">
                            <a href="{{ route('absensi.read') }}" class="btn btn-lihat btn-sm">Lihat Rekap Absensi</a>
                        </div>
                        @endif

                        {{-- Check Out --}}
                        @if ($sudahCheckIn && !$sudahCheckOut)
                        @if ($jamSekarang >= $jamPulang)
                        <div class="text-center">
                            <a class="btn btn-absen btn-sm mt-3 float"
                                href="{{ route('absensi.create', ['id' => $user->karyawan->id, 'type' => 'check-out']) }}"
                                wire:navigate>
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="d-none d-md-inline ms-1">Check Out</span>
                            </a>
                        </div>
                        @else
                        <div class="alert alert-info mt-3 text-center">
                            Check Out hanya bisa dilakukan setelah jam {{ $jamPulang }}.
                        </div>
                        @endif
                        @endif

                        {{-- Tidak Hadir --}}
                        @if (!$sudahCheckIn && !$sudahCheckOut)
                        <div class="text-center">
                            <a class="btn btn-outline-primary btn-sm mt-3 float {{ $bolehCheckIn ? '' : 'disabled' }}"
                                href="{{ $bolehCheckIn ? route('absensi.create', ['id' => $user->karyawan->id, 'type' => 'tidak hadir']) : '#' }}"
                                wire:navigate>
                                <i class="fas fa-user-times"></i>
                                <span class="d-none d-md-inline ms-1">Tidak Hadir</span>
                            </a>
                        </div>
                        @endif
                        @else
                        <div class="alert alert-warning text-center mt-3">
                            Akun Anda belum dikaitkan dengan data karyawan. Hubungi admin.
                        </div>
                        @endif

                </div>
            </div>
        </div>
        {{-- admin--}}
        @can('akses-admin')
        {{-- Kolom Sparepart Menipis --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-danger mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i> Sparepart Menipis
                    </h3>
                    <hr class="border border-2 opacity-50 mb-4">

                    @if ($stokmenipis != 0)
                    <p class="card-text mb-3">
                        Ditemukan <strong>{{ $stokmenipis }} sparepart</strong> dengan stok rendah:
                    </p>

                    <div class="list-group list-group-flush mb-3">
                        @foreach ($spareparts as $item)
                        <a href="{{ route('sparepart.show', ['id' => $item->id]) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            wire:navigate>
                            <span class="fw-semibold">{{ $item->nama }}</span>
                            <span class="badge bg-danger rounded-pill">{{ $item->stok }} tersisa</span>
                        </a>
                        @endforeach
                    </div>


                    <div class="text-center">
                        <a href="{{ route('sparepart.view') }}" class="btn btn-danger btn-sm" wire:navigate>Lihat Semua
                            Sparepart</a>
                    </div>
                    @else
                    <div class="text-center">
                        <img src="{{ asset('storage/icons/Checking boxes-amico.svg') }}" alt="stok aman" width="60%"
                            class="mb-3">
                        <h5 class="text-muted fw-semibold">Stok sparepart dalam kondisi aman</h5>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Kolom Quick Access --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-success mb-3">
                        <i class="fa-solid fa-universal-access"></i> Quick Access
                    </h3>
                    <hr class="border border-2 opacity-50 mb-4">

                    @foreach ([
                    ['route' => 'pelanggan.create', 'label' => 'Tambah Pelanggan', 'icon' => 'fa-user-plus'],
                    ['route' => 'service.create', 'label' => 'Tambah Service', 'icon' => 'fa-tools'],
                    ['route' => 'penjualan.create', 'label' => 'Tambah Penjualan', 'icon' => 'fa-cash-register'],
                    ['route' => 'konten.create', 'label' => 'Tambah Konten', 'icon' => 'fa-file-alt']
                    ] as $menu)
                    <div class="d-flex justify-content-between align-items-center mb-4 px-4">
                        <div class="d-flex align-items-center">
                            <i class="fas {{ $menu['icon'] }} text-muted me-2"></i>
                            <span class="fw-semibold">{{ $menu['label'] }}</span>
                        </div>
                        <a href="{{ route($menu['route']) }}" wire:navigate class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
        @endcan
        @endcan

        @can('owner')
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body" wire:poll.visible.3000ms='emitChartData'>
                    <h3 class="card-title text-center">
                        <i class="fa-solid fa-chart-simple"></i> Chart Absensi
                    </h3>
                    <hr class="border border-2 opacity-50">
                    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                        <canvas id="absensiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik Pendapatan --}}
        <div class="col-12 col-md-3">
            <div class="d-flex flex-column h-100 justify-content-between gap-3">
                <div class="card flex-fill h-100" wire:poll.visible.3000ms>
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa-solid fa-hand-point-up"></i> Karyawan Belum Absen

                        </h5>
                        <hr class="border border-2 opacity-50">
                        @if($belumAbsen->count() > 0)

                        <p class="card-text">
                            📌 ada <strong> {{ $belumAbsen->count() }} karyawan </strong> belum absen
                        </p>
                        <ol class="list-group list-group-numbered rounded px-3 py-2 my-3 shadow-sm">
                            @foreach($belumAbsen->take(5) as $karyawan)
                            <li class="d-flex align-items-center justify-content-between border-0 border-bottom">
                                <span class="fw-semibold text-dark">
                                    {{ $karyawan->nama }}
                                </span>
                            </li>
                            @endforeach
                        </ol>


                        @if($belumAbsen->count() > 5)
                        <p class="text-muted ">
                            Dan {{ $belumAbsen->count() - 5 }} karyawan lainnya belum absen...
                        </p>
                        @endif

                        @else
                        <div class="text-center">
                            <img src="{{ asset('storage/icons/Confirmed attendance-amico.svg') }}" alt="absen"
                                class="animate-pop" width="60%">
                            <h4 class="card-text semibold text-muted">Semua Karyawan Sudah absen</h4>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Sparepart Menipis --}}
        <div class="col-12 col-md-3">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-danger mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i> Sparepart Menipis
                    </h3>
                    <hr class="border border-2 opacity-50 mb-4">

                    @if ($stokmenipis != 0)
                    <p class="card-text mb-3">
                        Ditemukan <strong>{{ $stokmenipis }} sparepart</strong> dengan stok rendah:
                    </p>

                    <div class="list-group list-group-flush mb-3">
                        @foreach ($spareparts as $item)
                        <a href="{{ route('sparepart.show', ['id' => $item->id]) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                            wire:navigate>
                            <span class="fw-semibold">{{ $item->nama }}</span>
                            <span class="badge bg-danger rounded-pill">{{ $item->stok }} tersisa</span>
                        </a>
                        @endforeach
                    </div>


                    <div class="text-center">
                        <a href="{{ route('sparepart.view') }}" class="btn btn-danger btn-sm" wire:navigate>Lihat Semua
                            Sparepart</a>
                    </div>
                    @else
                    <div class="text-center">
                        <img src="{{ asset('storage/icons/Checking boxes-amico.svg') }}" alt="stok aman" width="60%"
                            class="mb-3">
                        <h5 class="text-muted fw-semibold">Stok sparepart dalam kondisi aman</h5>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endcan
    </div>
</div>
{{-- Script Chart --}}
@push('scripts')
<script>
    (function () {
        let pendapatanBulananChartInstance = null;
        let absensiChartInstance = null; // Changed to lowercase for consistency
        let chartInitialized = false;
        let livewireListenersAttached = false;

        function safeDestroyChart(instance) {
            if (instance) {
                try {
                    instance.destroy();
                } catch (e) {
                    console.warn('Failed to destroy chart:', e);
                }
            }
            return null;
        }

        function renderAbsensiChart(chartData) {
            const ctx = document.getElementById('absensiChart');
            if (!ctx) {
                console.log('absensiChart canvas not found');
                return;
            }

            // Normalize data if nested
            chartData = chartData?.chartData || chartData;

            if (!chartData || !Array.isArray(chartData)) {
                console.warn('Invalid absensi chart data');
                return;
            }

            const statusLabels = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha', 'lembur'];
            const lineColors = [
                '#4BC0C0', // hadir - teal
                '#FFCE56', // terlambat - yellow
                '#36A2EB', // izin - blue
                '#FF6384', // sakit - pink
                '#9966FF', // alpha - purple
                '#FF9F40'  // lembur - orange
            ];

            const datasets = chartData.map((item, index) => ({
                label: item.nama,
                data: statusLabels.map(status => item.status[status] || 0),
                fill: false,
                borderColor: lineColors[index % lineColors.length],
                backgroundColor: lineColors[index % lineColors.length],
                borderWidth: 2,
                tension: 0.1
            }));

            if (absensiChartInstance) {
                absensiChartInstance.data.labels = statusLabels;
                absensiChartInstance.data.datasets = datasets;
                absensiChartInstance.update();
            } else {
                absensiChartInstance = new Chart(ctx, {
                    type: 'line',
                    data: { labels: statusLabels, datasets: datasets },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Rekapitulasi Absensi Karyawan',
                                font: { size: 16 }
                            },
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, padding: 20 }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.raw} hari`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Jumlah Hari' },
                                ticks: { stepSize: 1, precision: 0 }
                            },
                            x: {
                                title: { display: true, text: 'Status Absensi' }
                            }
                        }
                    }
                });
            }
        }

        function renderPendapatanBulananChart(chartData)
        {
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

        function attachLivewireListeners() {
            if (livewireListenersAttached || !window.Livewire) return;

            Livewire.on('chart-pendapatan-updated', (event) => {
                renderPendapatanBulananChart(event?.chartData ?? event);
            });

            Livewire.on('chart-absensi-updated', (event) => {
                renderAbsensiChart(event?.chartData ?? event);
            });

            livewireListenersAttached = true;
        }

        function initializeChart() {
            if (chartInitialized) return;

            attachLivewireListeners(); // Fixed typo from attachLivewireListeners()

            // Initialize both charts if their elements exist
            const pendapatanData = @json($chartPendapatanBulanan ?? null);
            const absensiData = @json($chartStatusAbsensi ?? null);

            if (document.getElementById('chartPendapatanBulanan') && pendapatanData) {
                renderPendapatanBulananChart(pendapatanData);
            }

            if (document.getElementById('absensiChart') && absensiData) {
                renderAbsensiChart(absensiData);
            }

            chartInitialized = true;
        }

        // Event listeners
        document.addEventListener('livewire:navigated', () => {
            chartInitialized = false;
            livewireListenersAttached = false;
            setTimeout(initializeChart, 100);
        }, { once: true });

        if (document.readyState === 'complete') {
            initializeChart();
        } else {
            document.addEventListener('DOMContentLoaded', initializeChart);
        }

        document.addEventListener('livewire:before-unload', () => {
            pendapatanBulananChartInstance = safeDestroyChart(pendapatanBulananChartInstance);
            absensiChartInstance = safeDestroyChart(absensiChartInstance);
            livewireListenersAttached = false;
        });
    })();
</script>
@endpush