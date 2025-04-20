@extends( 'layouts.main' )
@section( 'title','Kelola Jenis Layanan Service' )
@section('navLayanan','active')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Daftar Jenis Layanan</h1>
</div>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
      <h1 class="h4">Data Jenis Layanan</h1>
      <div class="d-flex justify-content-end">
        <a href="{{ route('layanan.create') }}" class="btn btn-primary mb-3">+ Tambah Jenis Layanan</a>
      </div>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Estimasi Pengerjaan</th>
                    <th>Jenis Kendaraan</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jenis_layanans as $index => $jenislayanan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $jenislayanan->nama_layanan }}</td>
                    <td>{{ $jenislayanan->estimasi_pengerjaan}}</td>
                    <td>{{ $jenislayanan->jenis_kendaraan}}</td>
                    <td>Rp {{ number_format($jenislayanan->harga, 0, ',', '.') }}</td>
    
                    <td>{{ $jenislayanan->deskripsi}}</td>
                    <td class="text-center">
                        <a href="{{ route('layanan.edit', $jenislayanan->id) }}" class="btn btn-sm btn-warning">Edit</a>
    
                        <form action="{{ route('layanan.destroy', $jenislayanan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                        </form>
                    </td>
    
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Data Jenis Layanan belum ada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
  </div>


    

    
@endsection

