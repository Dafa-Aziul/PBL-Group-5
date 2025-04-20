@extends('layouts.appdatapelanggan')
@section('title', 'Data Pelanggan')

@section('content')

    <h1>Data Pelanggan</h1>

    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('data-pelanggan.create') }}" class="btn btn-primary mb-3">Tambah Data Pelanggan</a>

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
            @forelse ($dataPelanggan as $dp)
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
                        <a href="{{ route('data-pelanggan.edit', $dp->id_pegawai) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('data-pelanggan.destroy', $dp->id_pegawai) }}" method="POST" style="display:inline;">
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
@endsection
