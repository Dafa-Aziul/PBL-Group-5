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
