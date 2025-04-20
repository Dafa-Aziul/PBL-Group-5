@extends('layouts.main')
@section('title', 'Data Jenis Kendaraan')
@section('navKendaraan', 'active')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Jenis Kendaraan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
   </div>
</div>
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h1 class="h4">Edit Jenis Kendaraan</h1>
        <div class="d-flex justify-content-end">
            <a href="{{ route('jenis_kendaraan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('jenis_kendaraan.update', $jenisKendaraan->id_jenis) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Jenis</label>
                <input type="text" name="nama_jenis" class="form-control" value="{{ $jenisKendaraan->nama_jenis }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Merk</label>
                <input type="text" name="merk" class="form-control" value="{{ $jenisKendaraan->merk }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Model</label>
                <input type="text" name="model" class="form-control" value="{{ $jenisKendaraan->model }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ $jenisKendaraan->deskripsi }}</textarea>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <input type="submit" name="submit"class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>
</div>
@endsection
