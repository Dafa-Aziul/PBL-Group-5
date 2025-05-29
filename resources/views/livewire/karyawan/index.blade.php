<div>
    <h2 class="mt-4">Kelola Karyawan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('user.view') }}">Karyawan</a></li>
        <li class="breadcrumb-item active">Daftar Karyawan</li>
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
                <span class="d-none d-md-inline ms-1">Daftar Karyawan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('karyawan.create') }}" wire:navigate>
                    <i class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah karyawan</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
                {{-- Select Entries per page --}}
                <div class="d-flex align-items-center">
                    <select class="form-select" aria-label="Select entries per page" wire:model.live="perPage"
                        style="width: auto;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <p for="perPage" class="ms-2 mb-0 text-muted">Entri per pages</p>
                </div>

                {{-- Search Input with Icon --}}
                <div class="position-relative" style="width: 30ch;">
                    <input type="text" class="form-control ps-5" placeholder="Cari"
                        wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
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
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawans as $karyawan)
                        <tr>
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
                                <span class="btn btn-success btn-sm">Aktif</span>
                                @else
                                <span class="btn btn-secondary btn-sm">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <img src="{{ $karyawan->foto ? asset('storage/images/profile/' . $karyawan->foto) : asset('foto/default.png') }}"
                                    alt="Foto Karyawan" width="80" height="80" class="rounded-circle">

                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('karyawan.edit', ['id' => $karyawan->id]) }}"
                                        class="btn btn-warning btn-sm me-1">
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
