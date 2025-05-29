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

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1 semibold">Rekap Absensi</span>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage"
                        style="width:auto;cursor:pointer;">
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                    </select>
                    <p for="perPage" class="d-none d-md-inline ms-2 mb-0 text-muted ">Entries per page</p>
                </div>

                <!-- Search Input with Icon -->
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Search"
                        wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>

                <select class="form-select" wire:model.live="filterBulan" style="width:auto;cursor:pointer;">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $bulan)
                    <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F')
                        }}</option>
                    @endforeach
                </select>

                <!-- Filter Minggu -->
                <select class="form-select" wire:model.live="filterMinggu" style="width: 150px;">
                    <option value="">Semua Minggu</option>
                    @for ($i = 1; $i <= 5; $i++) <option value="{{ $i }}">Minggu ke-{{ $i }}</option>
                        @endfor
                </select>

                <!-- Filter Status -->
                <select class="form-select" wire:model.live="filterStatus" style="width:auto;cursor:pointer;">
                    <option value="">Semua Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="terlambat">Terlambat</option>
                    <option value="lembur">Lembur</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="alpha">Alpha</option>
                </select>

                <!-- Sort Tanggal -->
                <select class="form-select" wire:model.live="sortDirection" style="width: 150px;">
                    <option value="desc">Terbaru</option>
                    <option value="asc">Terlama</option>
                </select>

                <div class="d-flex">
                    <!-- Filter Bulan -->

                </div>

            </div>

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