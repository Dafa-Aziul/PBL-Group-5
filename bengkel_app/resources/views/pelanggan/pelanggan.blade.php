@extends( 'layouts.main' )
@section( 'title','Kelola Pelanggan' )
@section('navPelanggan','active')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Pelanggan</h1>
</div>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
      <h1 class="h4">Data Pelanggan</h1>
      <div class="d-flex justify-content-end">
        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary mb-3">+ Tambah Pelanggan</a>
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
                @forelse ($pelanggans as $index => $pelanggan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $pelanggan->nama_pelanggan }}</td>
                    <td>{{ $pelanggan->email}}</td>
                    <td>{{ $pelanggan->no_telp}}</td>
                    <td>{{ $pelanggan->alamat}}</td>
                    <td>{{ $pelanggan->no_polisi}}</td>
                    <td>{{ $pelanggan->jenis_kendaraan}}</td>
                    <td>{{ $pelanggan->model}}</td>
                    <td>{{ $pelanggan->ket}}</td>
                    <td class="text-center">
                        <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-sm btn-warning">Edit</a>
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

   
@endsection

