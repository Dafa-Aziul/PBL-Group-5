@extends('layouts.main')
@section('title', 'Data Karyawan')
@section('navKaryawan', 'active')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Karyawan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
       </div>
    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h1 class="h4">Daftar Karyawan</h1>
        <div class="d-flex justify-content-end">
        <a href="{{ route('data-karyawan.create') }}" class="btn btn-primary mb-3">Tambah Data Karyawan</a>
        </div>
    </div>
    <div class="card-body">
    <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Tanggal Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataKaryawan as $dp)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dp->nama }}</td>
                        <td>{{ $dp->jabatan }}</td>
                        <td>{{ $dp->email }}</td>
                        <td>{{ $dp->no_hp }}</td>
                        <td>{{ $dp->alamat }}</td>
                        <td>{{ $dp->tanggal_masuk }}</td>
                        <td>{{ $dp->status }}</td>
                        <td>
                            <a href="{{ route('data-karyawan.edit', $dp->id_karyawan) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('data-karyawan.destroy', $dp->id_karyawan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
@endsection