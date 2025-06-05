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


    
    <div class="row d-flex align-items-stretch">
        
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
        @endcan

        @can('akses-owner')
        <div class="col-12 col-md-9">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-center">
                        <i class="fa-solid fa-clipboard-user"></i> Absen Hari Ini

                    </h3>
                    <hr class="border border-2 opacity-50">
                    <div class="row px-3">
                        <div class="col-md-7">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h3 class="card-title text-center">
                                        <i class="fa-solid fa-chart-simple"></i> Chart Absensi
                                    </h3>
                                    <hr class="border border-2 opacity-50">
                                    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                                        {{-- <canvas id="myChart" width="200" height="200"></canvas> --}}
                                        <canvas id="statusChart" width="800" height="400"></canvas>
                                    </div>


                                </div>
                            </div>
                        </div>

                        {{-- Statistik Pendapatan --}}
                        <div class="col-12 col-md-5">
                            <div class="d-flex flex-column h-100 justify-content-between gap-3">
                                <div class="card flex-fill h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fa-solid fa-hand-point-up"></i>   Karyawan Belum Absen

                                        </h5>
                                        <hr class="border border-2 opacity-50">
                                        @if($belumAbsen->count() > 0)

                                        <p class="card-text">
                                            📌 ada <strong> {{ $belumAbsen->count() }} karyawan </strong> belum absen
                                        </p>
                                        <ol class="list-group list-group-numbered rounded px-3 py-2 my-3 shadow-sm">
                                            @foreach($belumAbsen->take(5) as $karyawan)
                                            <li
                                                class="d-flex align-items-center justify-content-between border-0 border-bottom">
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
                                            <img src="{{ asset('storage/icons/Confirmed attendance-amico.svg') }}"
                                                alt="absen" class="animate-pop" width="60%">
                                            <h4 class="card-text semibold text-muted">Semua Karyawan Sudah absen</h4>
                                        </div>
                                        @endif




                                    </div>
                                </div>
                                

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        {{-- Kolom Sparepart Menipis --}}
        <div class="col-12 col-md-3">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i> Sparepart Menipis
                    </h3>
                    <hr class="border border-2 opacity-50">

                    @if ($stokmenipis != 0)
                    <p class="card-text">
                        Ada <strong>{{ $stokmenipis }} sparepart</strong> dengan stok menipis:
                    </p>
                    <ul class="list-group list-group-flush mt-3">
                        @foreach ($spareparts as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ $item->nama }}</strong>
                            <span class="badge bg-danger rounded-pill">{{ $item->stok }} stok tersisa</span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="text-center">
                        <a href="{{ route('sparepart.view') }}" class="btn btn-danger btn-sm mt-3">Lihat Detail</a>
                    </div>
                    @else
                    <div class="text-center">
                        <img src="{{ asset('storage/icons/Checking boxes-amico.svg') }}" alt="empty stok" width="60%">
                        <h4 class="card-text semibold text-muted">Stok sparepart aman</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endcan

        {{-- admin--}}
        @can('akses-admin')
        {{-- Kolom Sparepart Menipis --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i> Sparepart Menipis
                    </h3>
                    <hr class="border border-2 opacity-50">

                    @if ($stokmenipis != 0)
                    <p class="card-text">
                        Ada <strong>{{ $stokmenipis }} sparepart</strong> dengan stok menipis:
                    </p>
                    <ul class="list-group list-group-flush mt-3">
                        @foreach ($spareparts as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ $item->nama }}</strong>
                            <span class="badge bg-danger rounded-pill">{{ $item->stok }} stok tersisa</span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="text-center">
                        <a href="{{ route('sparepart.view') }}" class="btn btn-danger btn-sm mt-3">Lihat Detail</a>
                    </div>
                    @else
                    <div class="text-center">
                        <img src="{{ asset('storage/icons/Checking boxes-amico.svg') }}" alt="empty stok" width="60%">
                        <h4 class="card-text semibold text-muted">Stok sparepart aman</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endcan

        {{-- admin --}}
        @can('akses-admin')
        {{-- Kolom Quick Access --}}
        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-success">
                        <i class="fa-solid fa-universal-access"></i> Quick Access
                    </h3>
                    <hr class="border border-2 opacity-50">

                    @foreach ([
                    ['route' => 'sparepart.create', 'label' => 'Tambah Sparepart'],
                    ['route' => 'pelanggan.create', 'label' => 'Tambah Pelanggan'],
                    ['route' => 'karyawan.create', 'label' => 'Tambah Karyawan'],
                    ['route' => 'jasa.create', 'label' => 'Tambah Jasa']
                    ] as $menu)
                    <div class="mb-3">
                        <a class="btn btn-primary w-100" href="{{ route($menu['route']) }}" wire:navigate>
                            <i class="fas fa-plus"></i>
                            <span class="ms-1">{{ $menu['label'] }}</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endcan
    </div>



    @can('akses-admin-owner')
    {{-- Bagian Chart Transaksi --}}
    <div class="row d-flex align-items-stretch my-3">
        <div class="col-12">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-center text-success">
                        <i class="fa-solid fa-cash-register"></i> Transaksi Bulan Ini
                    </h3>
                    <hr class="border border-2 opacity-50">
                    <div class="row px-3">
                        <div class="col-md-9">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h3 class="card-title text-center text-success">
                                        <i class="fa-solid fa-chart-simple"></i> Chart Transaksi
                                    </h3>
                                    <hr class="border border-2 opacity-50">
                                    <canvas id="transaksiChart"></canvas>
                                </div>
                            </div>
                        </div>

                        {{-- Statistik Pendapatan --}}
                        <div class="col-12 col-md-3">
                            <div class="d-flex flex-column h-100 justify-content-between gap-3">
                                {{-- Status Pembayaran --}}
                                <div class="card  flex-fill">
                                    <div class="card-body d-flex flex-column" style="height: 100%;">
                                        <h5 class="card-title text-success">
                                            <i class="fa-solid fa-money-bill-1-wave"></i> Total Pendapatan
                                        </h5>
                                        <hr class="border border-2 opacity-50">
                                        <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                                            <h2 class="fw-bold text-dark text-center mb-0">
                                                Rp {{ number_format($totalTransaksi, 0, ',', '.') }}
                                            </h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="card  flex-fill">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-success">
                                            <i class="fa-solid fa-circle-dollar-to-slot"></i> Rata-Rata Pendapatan
                                            {{-- <small class="text-muted" style="font-size: 0.65em;">/transaksi</small>
                                            --}}
                                        </h5>
                                        <hr class="border border-2 opacity-50">
                                        <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                                            <h2 class="fw-bold text-dark text-center mb-0">
                                                Rp {{ number_format($avgPendapatan, 0, ',', '.') }}
                                            </h2>



                                        </div>

                                    </div>
                                </div>
                                {{-- Jenis Transaksi --}}

                                <div class="card  flex-fill">
                                    <div class="card-body d-flex flex-column" style="height: 100%;">
                                        <h5 class="card-title text-success">
                                            <i class="fa-solid fa-file-invoice-dollar"></i> Jumlah Transaksi
                                        </h5>
                                        <hr class="border border-2 opacity-50">
                                        <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                                            <h2 class="fw-bold text-dark text-center mb-0">{{ $jumlahTransaksi }}
                                                transaksi</h2>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @endcan
    {{-- Script Chart --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // chart transaksi
        const transaksiData = @json($chartTransaksi);

        let mingguSet = new Set(transaksiData.map(item => item.minggu));
        for (let i = 1; i <= 4; i++) mingguSet.add(i);
        const mingguNumbers = [...mingguSet].sort((a, b) => a - b);
        const mingguLabels = mingguNumbers.map(m => 'Minggu ' + m);
        const jenisList = [...new Set(transaksiData.map(item => item.jenis_transaksi))];

        const jumlahDatasets = jenisList.map(jenis => ({
            label: `Jumlah - ${jenis}`,
            data: mingguNumbers.map(mingguKe => transaksiData.find(item => item.jenis_transaksi === jenis && item.minggu === mingguKe)?.jumlah || 0),
            borderColor: getColor(jenis, false),
            backgroundColor: getColor(jenis, true),
            fill: false,
            tension: 0.3,
            yAxisID: 'y'
        }));

        const totalDatasets = jenisList.map(jenis => ({
            label: `Total - ${jenis}`,
            data: mingguNumbers.map(mingguKe => transaksiData.find(item => item.jenis_transaksi === jenis && item.minggu === mingguKe)?.total || 0),
            borderColor: getColor(`${jenis}-total`, false),
            backgroundColor: getColor(`${jenis}-total`, true),
            fill: false,
            tension: 0.3,
            yAxisID: 'y1',
            pointStyle: 'triangle',
            pointRadius: 6
        }));

        new Chart(document.getElementById('transaksiChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: mingguLabels,
                datasets: [...jumlahDatasets, ...totalDatasets]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                stacked: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Transaksi' },
                        ticks: {
                            callback: value => value.toLocaleString()
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        suggestedMax: 10000000,
                        grid: { drawOnChartArea: false },
                        title: { display: true, text: 'Total Pendapatan (Rp)' },
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString(),
                            color: '#FF8000'
                        }
                    }
                }
            }
        });

        function getColor(key, isBackground) {
            const colors = {
                'penjualan': '255, 99, 132',
                'service': '54, 162, 235',
                'penjualan-total': '255, 159, 64',
                'service-total': '75, 192, 192'
            };
            const color = colors[key] || '100, 100, 100';
            return isBackground ? `rgba(${color}, 0.2)` : `rgba(${color}, 1)`;
        }

        //chart status absen
        const chartStatus = @json($chartStatus);
        const doughnutLabels = chartStatus.labels;
        const doughnutData = chartStatus.data;

        const doughnutColors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
            'rgb(201, 203, 207)',
            'rgb(100, 149, 237)',
            'rgb(220, 20, 60)',
            'rgb(34, 139, 34)'
        ];

        new Chart(document.getElementById('myChart'), {
            type: 'doughnut',
            data: {
                labels: doughnutLabels,
                datasets: [{
                    label: 'Status Absensi Bulan Ini',
                    data: doughnutData,
                    backgroundColor: doughnutColors.slice(0, doughnutLabels.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const chartStatusData = @json($chartStatusAbsensi);
        const statusLabels = ['hadir', 'terlambat', 'izin', 'sakit', 'alpha', 'lembur'];

        const lineColors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
        '#FF9F40', '#00A676', '#C71585', '#4682B4', '#228B22',
        '#FF4500', '#8A2BE2', '#20B2AA', '#DC143C', '#00CED1',
        '#DAA520', '#7B68EE', '#3CB371', '#FF1493', '#708090',
        '#CD5C5C', '#6B8E23', '#FF7F50', '#2E8B57', '#800080',
        '#1E90FF', '#B22222', '#9ACD32', '#8B4513', '#5F9EA0'
        ];


        const datasets = chartStatusData.map((item, index) => ({
            label: item.nama,
            data: statusLabels.map(status => item.status[status]),
            fill: false,
            borderColor: lineColors[index % lineColors.length],
            backgroundColor: lineColors[index % lineColors.length],
            tension: 0.3
        }));

        new Chart(document.getElementById('statusChart'), {
            type: 'line',
            data: {
                labels: statusLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Rekapitulasi Absensi Karyawan (Per Status)'
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Hari'
                        },
                        ticks: {
                precision: 0, // untuk memastikan hanya integer
                stepSize: 1   // loncatan antar angka
            }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Status Absensi'
                        }
                    }
                }
            }
        });

    </script>
    @endpush
</div>