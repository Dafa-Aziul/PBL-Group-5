@php
use Carbon\Carbon;
Carbon::setLocale('id'); // Biar hari & bulan pakai bahasa Indonesia
$user = auth()->user();
$now = Carbon::now();
$today = $now->toDateString();
$jamSekarang = $now->format('H:i');
$jamPulang = '17:00';

$absenHariIni = $user->karyawans
? $user->karyawans->absensis()->whereDate('tanggal', $today)->first()
: null;

$sudahCheckIn = $absenHariIni && $absenHariIni->jam_masuk;
$sudahCheckOut = $absenHariIni && $absenHariIni->jam_keluar;

$statusText = 'Belum Absen';

if ($sudahCheckIn && !$sudahCheckOut) {
$statusText = 'Kamu sudah Check In';
} elseif ($sudahCheckIn && $sudahCheckOut) {
$statusText = 'Selamat beristirahat!';
}
$tidakHadirList = $absensis->filter(function($item) {
return in_array(strtolower($item->status), ['izin', 'sakit']);
});

$statusHariIni = $absenHariIni ? strtolower($absenHariIni->status) : null;
$bolehCheckIn = !in_array($statusHariIni, ['izin', 'sakit']);

@endphp
<div>
    <h2 class="mt-4">Absen</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('absensi.view') }}">Absen</a></li>

    </ol>
    @if (session()->has('success'))
    <div class="        ">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div @elseif (session()->has('error'))
    <div class="">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
    @endif



    <div class="row g-3">
        <div class="col-12 col-md-3">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="fa-solid fa-clipboard-user"></i> Absen Hari ini
                    </h3>

                    <label class="text-muted">
                        {{ Carbon::now()->translatedFormat('l, d F Y') }}
                    </label>
                    <hr class="border border-2 opacity-50">

                    <h4 class="text-center my-5" style="font-weight: bold">{{ $statusText }}</h4>

                    @if ($user && $user->karyawans)
                    {{-- Tombol Check In --}}
                    @if (!$sudahCheckIn)
                    @if ($jamSekarang < $jamPulang) <div class="text-center">
                        <a class="btn btn-absen btn-sm mt-3 float {{ $bolehCheckIn ? '' : 'disabled' }}"
                            href="{{ $bolehCheckIn ? route('absensi.create', ['id' => $user->karyawans->id, 'type' => 'check-in']) : '#' }}"
                            wire:navigate @if (!$bolehCheckIn) aria-disabled="true" tabindex="-1" @endif>
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline ms-1">Check In</span>
                        </a>
                </div>
                @else
                <div class="text-center">
                    <div class="alert alert-warning text-center mt-3">
                        Anda sudah melewati jam pulang status anda alpha.
                    </div>
                </div>
                @endif
                @endif


                {{-- Tombol Check Out --}}
                @if ($sudahCheckIn && !$sudahCheckOut && $jamSekarang >= $jamPulang)
                <div class="text-center">
                    <a class="btn btn-absen btn-sm mt-3 float"
                        href="{{ route('absensi.create', ['id' => $user->karyawans->id, 'type' => 'check-out']) }}"
                        wire:navigate>
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="d-none d-md-inline ms-1">Check Out</span>
                    </a>
                </div>
                @elseif ($sudahCheckIn && !$sudahCheckOut && $jamSekarang < $jamPulang) <div
                    class="alert alert-info mt-3 text-center">
                    Check Out hanya bisa dilakukan setelah jam {{ $jamPulang }}.
            </div>
            @endif


            @if (!$sudahCheckIn && !$sudahCheckOut)
            <div class="text-center">
                <a class="btn btn-outline-primary btn-sm mt-3 float {{ $bolehCheckIn ? '' : 'disabled' }}"
                    href="{{ $bolehCheckIn ? route('absensi.create', ['id' => $user->karyawans->id, 'type' => 'tidak-hadir']) : '#' }}"
                    wire:navigate>
                    <i class="fas fa-user-times"></i>
                    <span class="d-none d-md-inline ms-1">Tidak Hadir</span>
                </a>
            </div>
            @endif

            @else
            <div class="alert alert-warning text-center mt-3">
                Akun Anda belum dikaitkan dengan data karyawans. Hubungi admin.
            </div>
            @endif



        </div>
    </div>

</div>

<div class="col-12 col-md-9">

    @if ($tidakHadirList->isNotEmpty())
    <div class="card mb-4 card-hover">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-user-times me-1"></i>
                <span class="d-none d-md-inline ms-1 ">Data Tidak Hadir</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-danger">
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Bukti Tidak Hadir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tidakHadirList as $absensi)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $absensi->status }}</td>
                            <td>{{ $absensi->keterangan }}</td>
                            <td class="text-center">
                                @if ($absensi->bukti_tidak_hadir)
                                <img src="{{ asset('storage/' . $absensi->bukti_tidak_hadir) }}" alt="Bukti Tidak Hadir"
                                    class="img-thumbnail"
                                    style="max-width: 150px; max-height: 150px; object-fit: contain; cursor: zoom-in;"
                                    data-bs-toggle="modal" data-bs-target="#fotoModal{{ $absensi->id }}">
                                @else
                                <span class="text-muted">Tidak ada bukti</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="card mb-4 card-hover">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1 ">Absen Masuk</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Jam masuk</th>
                            <th>Foto Masuk</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($absensis as $index => $absensi)
                        <tr>
                            <td>{{ $absensi->jam_masuk}}</td>
                            <td class="text-center">
                                <img src="{{ $absensi->foto_masuk ? asset('storage/absensi/foto_masuk/' . $absensi->foto_masuk) : asset('foto/default.png') }}"
                                    alt="Foto Masuk" class="img-thumbnail"
                                    style="max-width: 150px; max-height: 150px; object-fit: contain; cursor: zoom-in;"
                                    data-bs-toggle="modal" data-bs-target="#fotoModal{{ $absensi->id }}">
                            </td>

                            <td>{{ $absensi->status}}</td>
                            <td>{{ $absensi->keterangan}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse

                </table>
            </div>

        </div>
    </div>

    <div class="card mb-4 card-hover">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1 ">Absen Pulang</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Jam Keluar</th>
                            <th>Foto Keluar</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        @forelse ($absensis as $index => $absensi)
                        <tr>
                            <td>{{ $absensi->jam_keluar}}</td>
                            <td class="text-center">
                                @if ($absensi->foto_keluar)
                                <img src="{{ $absensi->foto_keluar ? asset('storage/' . $absensi->foto_keluar) : asset('foto/default.png') }}"
                                    alt="Foto Keluar" class="img-thumbnail"
                                    style="max-width: 150px; max-height: 150px; object-fit: contain;"
                                    data-bs-toggle="modal" data-bs-target="#fotoModal{{ $absensi->id }}"
                                    style="cursor: zoom-in;">
                                @else
                                -
                                @endif

                            </td>
                            <td>{{ $absensi->jam_keluar ? $absensi->status : "-" }}</td>

                            <td>{{ $absensi->keterangan}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse

                </table>
            </div>

        </div>
    </div>
    @endif

    <div class="text-center">
        <a href="{{route('absensi.read')}}" class="btn btn-lihat btn-sm">Lihat Rekap Absensi</a>
    </div>

</div>

</div>




</div>
