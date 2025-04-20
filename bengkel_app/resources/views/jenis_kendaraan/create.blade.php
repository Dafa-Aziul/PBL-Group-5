@extends('layouts.main')
@section('title', 'Data Jenis Kendaraan')
@section('navKendaraan', 'active')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Jenis Kendaraan</h1>
</div>
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h1 class="h4">Daftar Jenis Kendaran</h1>
        <div class="d-flex justify-content-end">
          <a href="{{ route('jenis_kendaraan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('jenis_kendaraan.store') }}" method="POST">
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
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <input type="submit" name="submit"class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-warning ms-2" value="Batal">
            </div>
        </form>
    </div>
</div>
@endsection
