{{-- resources/views/data-Karyawan/create.blade.php --}}
@extends('layouts.main')
@section('title', 'Tambah Data Karyawan')

@section('content')
<h1>Tambah Data Karyawan</h1>

<form action="{{ route('data-karyawan.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="id_user" class="form-label">User</label>
        <select class="form-select" name="id_user" required>
            <option value="" disabled selected>Pilih User</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama" required>
    </div>

    <div class="mb-3">
        <label for="jabatan" class="form-label">Jabatan</label>
        <input type="text" class="form-control" name="jabatan" required>
    </div>

    <div class="mb-3">
        <label for="no_hp" class="form-label">Nomor HP</label>
        <input type="text" class="form-control" name="no_hp" required>
    </div>

    <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" name="alamat" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
        <input type="date" class="form-control" name="tanggal_masuk" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" name="status" required>
            <option value="Aktif">Aktif</option>
            <option value="Nonaktif">Nonaktif</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('data-karyawan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
