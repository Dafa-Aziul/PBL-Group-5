@extends('layouts.appdatapelanggan')

@section('content')
<div class="container mt-4">
    <h2>Edit Jenis Kendaraan</h2>
    <form action="{{ route('jenis-kendaraan.update', $jenisKendaraan->id_jenis) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengupdate data ini?')">
    <!-- <form action="{{ route('jenis-kendaraan.update', $jenisKendaraan->id_jenis) }}" method="POST"> -->
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Jenis:</label>
            <input type="text" name="nama_jenis" class="form-control" value="{{ $jenisKendaraan->nama_jenis }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Merk:</label>
            <input type="text" name="merk" class="form-control" value="{{ $jenisKendaraan->merk }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Model:</label>
            <input type="text" name="model" class="form-control" value="{{ $jenisKendaraan->model }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun:</label>
            <input type="number" name="tahun" class="form-control" value="{{ $jenisKendaraan->tahun }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi:</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ $jenisKendaraan->deskripsi }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
