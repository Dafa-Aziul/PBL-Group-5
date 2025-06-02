<div>
    <h2 class="mt-4">Kelola Absensi</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('absensi.view') }}">Absensi</a></li>
        <li class="breadcrumb-item active">Rekap Absensi</li>
    </ol>

    {{-- Perbaikan session flash message --}}
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @elseif (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4">
            <div class="d-flex flex-column h-100 justify-content-between gap-3">
                {{-- Status Pembayaran --}}
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-money-bill-1-wave"></i> Rekap Status Absensi
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="text-center">
                            <canvas id="myChart" width="300" height="300"></canvas>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
            <div class="d-flex flex-column h-100 justify-content-between gap-3">
                {{-- Status Pembayaran --}}
                <div class="card card-jumlah flex-fill card-hover">
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            <i class="fa-solid fa-user-tie"></i> Rekap Absen Karyawan
                        </h5>
                        <hr class="border border-2 opacity-50">
                        <div class="text-center">
                            <canvas id="statusChart" width="800" height="400"></canvas>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row g-2 mb-3">

        <!-- Filter Bulan -->
        <div class="col-6 col-md-3">
            <select class="form-select" wire:model.live="filterBulan" style="cursor:pointer;">
                <option value="">Semua Bulan</option>
                @foreach(range(1, 12) as $bulan)
                <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Minggu -->
        <div class="col-6 col-md-3">
            <select class="form-select" wire:model.live="filterMinggu">
                <option value="">Semua Minggu</option>
                @for ($i = 1; $i <= 5; $i++) <option value="{{ $i }}">Minggu ke-{{ $i }}</option>
                    @endfor
            </select>
        </div>

        <!-- Filter Status -->
        <div class="col-6 col-md-3">
            <select class="form-select" wire:model.live="filterStatus" style="cursor:pointer;">
                <option value="">Semua Status</option>
                <option value="hadir">Hadir</option>
                <option value="terlambat">Terlambat</option>
                <option value="lembur">Lembur</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
            </select>
        </div>

        <!-- Sort Tanggal -->
        <div class="col-6 col-md-3">
            <select class="form-select" wire:model.live="sortDirection">
                <option value="desc">Terbaru</option>
                <option value="asc">Terlama</option>
            </select>
        </div>

    </div>

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1 semibold">Rekap Absensi</span>
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
                                <img src="{{ $absensi->foto_masuk ? asset('storage/' . $absensi->foto_masuk) : asset('foto/default.png') }}"
                                    alt="Foto Masuk" class="img-thumbnail"
                                    style="max-width: 100px; max-height: 100px; object-fit: contain;">
                            </td>

                            {{-- Foto keluar, dengan fallback default --}}
                            <td class="text-center">
                                <img src="{{ $absensi->foto_keluar ? asset('storage/' . $absensi->foto_keluar) : asset('foto/default.png') }}"
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
                            <td colspan="9" class="text-center text-muted">Tidak ada data absensi yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
                {{ $absensis->links() }}
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Chart Doughnut (Total status bulanan)
    const chartData = @json($chartData);
    const doughnutLabels = chartData.labels;
    const doughnutData = chartData.data;

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
            responsive: false
        }
    });

    // Chart Line (Per karyawan)
    const chartStatusData = @json($chartStatus);
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



</div>