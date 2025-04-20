@extends('layouts.appdatapelanggan')

@section('content')
<div class="card mt-4">
    <div class="card-header">
        Tambah Jenis Kendaraan
    </div>
    <div class="card-body">
        <form action="{{ route('jenis-kendaraan.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_jenis" class="form-label">Nama Jenis</label>
                <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" required>
            </div>

            <div class="mb-3">
                <label for="merk" class="form-label">Merk</label>
                <input type="text" class="form-control" id="merk" name="merk" required>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>

            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
