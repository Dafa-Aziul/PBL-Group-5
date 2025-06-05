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
                    <span class="d-none d-md-inline ms-1">Absensi Hari Ini</span>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    {{-- perPage --}}
                    <div class="d-flex align-items-center">
                        <select class="form-select" wire:model="perPage" style="width: auto;">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>
                        <label class="ms-2 mb-0 text-muted">Entri per pages</label>
                    </div>

                    {{-- search --}}
                    <div class="position-relative" style="width: 30ch;">
                        <input type="text" class="form-control ps-5" placeholder="Cari"
                            wire:model.live.debounce.300ms="search" />
                        <i
                            class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
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
                                    <img src="{{ $absensi && $absensi->foto_masuk ? asset('storage/' . $absensi->foto_masuk) : asset('foto/default.png') }}"
                                        alt="Foto Masuk" class="img-thumbnail" style="max-width: 100px;">
                                </td>
                                <td class="text-center">
                                    <img src="{{ $absensi && $absensi->foto_keluar ? asset('storage/' . $absensi->foto_keluar) : asset('foto/default.png') }}"
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
