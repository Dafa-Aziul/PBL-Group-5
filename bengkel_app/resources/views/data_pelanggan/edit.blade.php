@extends('layouts.appjeniskendaraan')

@section('title', 'Edit Data Pelanggan')
@section('navPelanggan', 'active')

@section('content')
<div class="container mt-4">
    <h2>Edit Data Pelanggan</h2>
    <form action="{{ route('data-pelanggan.update', $pelanggan->id_pegawai) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengupdate data ini?')">
    @csrf
    @method('PUT')

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">ID User:</label>
            <input type="number" name="id_user" class="form-control" value="{{ $pelanggan->id_user }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $pelanggan->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama:</label>
            <input type="text" name="nama" class="form-control" value="{{ $pelanggan->nama }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jabatan:</label>
            <input type="text" name="jabatan" class="form-control" value="{{ $pelanggan->jabatan }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor HP:</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $pelanggan->no_hp }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat:</label>
            <textarea name="alamat" class="form-control" rows="3" required>{{ $pelanggan->alamat }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Masuk:</label>
            <input type="date" name="tanggal_masuk" class="form-control" value="{{ $pelanggan->tanggal_masuk }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status:</label>
            <select name="status" class="form-control" required>
                <option value="Aktif" {{ $pelanggan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ $pelanggan->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
