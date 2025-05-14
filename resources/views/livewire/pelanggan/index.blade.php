<div>
    <h1 class="mt-4">Kelola Jenis kendaraan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('pelanggan.view') }}">Jenis Kendaraan</a></li>
        <li class="breadcrumb-item active">Daftar Jenis Kendaraan</li>
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



    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <div class="d-flex justify-content-end">
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">+ Tambah Pelanggan</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Email</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>No Polisi</th>
                        <th>Jenis Kendaraan</th>
                        <th>Model</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $pelanggan->nama_pelanggan }}</td>
                        <td>{{ $pelanggan->email }}</td>
                        <td>{{ $pelanggan->no_telp }}</td>
                        <td>{{ $pelanggan->alamat }}</td>
                        <td>{{ $pelanggan->no_polisi }}</td>
                        <td>{{ $pelanggan->jenis_kendaraan }}</td>
                        <td>{{ $pelanggan->model }}</td>
                        <td>{{ $pelanggan->ket }}</td>
                        <td class="text-center">
                            <a href="{{ route('pelanggan.edit', $pelanggan->id) }}"
                                class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Data pelanggan belum ada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>