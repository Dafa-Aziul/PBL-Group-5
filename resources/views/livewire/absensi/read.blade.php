<div>
    <h2 class="mt-4">Absensi Hari Ini</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('absensi.view') }}">Absensi</a></li>
        <li class="breadcrumb-item active">Absensi Hari Ini</li>
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
                <span class="ms-1">Daftar absensi Hari Ini</span>
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
                        @forelse ($karyawans as $karyawan)
                        @php
                        $absensi = $karyawan->absensis->first(); // hanya 1 absensi per karyawan per hari
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($karyawans->firstItem() - 1) }}</td>
                            <td>{{ $karyawan->nama }}</td>
                            <td>{{ $absensi ? \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') :
                                '-' }}</td>
                            <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                            <td>{{ $absensi->jam_keluar ?? '-' }}</td>
                            <td class="text-center">
                                <img src="{{ asset(
                                        optional($absensi)?->bukti_tidak_hadir
                                            ? 'storage/absensi/foto_tidak_hadir/' . optional($absensi)->bukti_tidak_hadir
                                            : (optional($absensi)?->foto_masuk
                                                ? 'storage/absensi/foto_masuk/' . optional($absensi)->foto_masuk
                                                : 'images/user/default.jpg')
                                    ) }}" alt="Foto Absensi" class="img-thumbnail" style="max-width: 100px;">
                            </td>
                            <td class="text-center">
                                <img src="{{ $absensi && $absensi->foto_keluar ? asset('storage/absensi/foto_keluar/' . $absensi->foto_keluar) : asset('images/user/default.jpg') }}"
                                    alt="Foto Keluar" class="img-thumbnail" style="max-width: 100px;">
                            </td>
                            <td>{{ $absensi->status ?? 'Belum Absen' }}</td>
                            <td>{{ $absensi->keterangan ?? '-' }}</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data karyawan.</td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
                {{ $karyawans->links() }}
            </div>
        </div>
    </div>
</div>
