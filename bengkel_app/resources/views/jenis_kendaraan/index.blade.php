@extends('layouts.appdatapelanggan')
@section('title', 'Data Pelanggan')
@section('navKendaraan', 'active')

@section('content')
    
    <h1>Daftar Jenis Kendaraan</h1>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('jenis-kendaraan.create') }}" class="btn btn-primary mb-3">Tambah Jenis Kendaraan</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Jenis</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Tahun</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jenisKendaraans as $jk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $jk->nama_jenis }}</td>
                    <td>{{ $jk->merk }}</td>
                    <td>{{ $jk->model }}</td>
                    <td>{{ $jk->tahun }}</td>
                    <td>{{ $jk->deskripsi }}</td>
                    <td>
                        <a href="{{ route('jenis-kendaraan.edit', $jk->id_jenis) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('jenis-kendaraan.destroy', $jk->id_jenis) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data jenis kendaraan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
