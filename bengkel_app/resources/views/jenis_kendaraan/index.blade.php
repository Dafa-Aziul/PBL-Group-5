@extends('layouts.main')
@section('title', 'Data Pegawai')
@section('navKendaraan', 'active')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Daftar Jenis Kendaraan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
       </div>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h1 class="h4">Daftar Jenis Kendaraan</h1>
        <div class="d-flex justify-content-end">
        <a href="{{ route('jenis-kendaraan.create') }}" class="btn btn-primary mb-3">Tambah Jenis Kendaraan</a>
        </div>
    </div>
    <div class="card-body">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Jenis</th>
                <th>Merk</th>
                <th>Model</th>
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
</div>
</div>
@endsection
