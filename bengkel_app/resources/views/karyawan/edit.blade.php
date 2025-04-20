@extends('layouts.main')

@section('title', 'Edit Data Karyawan')
@section('navKaryawan', 'active')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Karyawan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
    </div>
</div>  

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h1 class="h4">Edit Data Karyawan</h1>
        <div class="d-flex justify-content-end">
            <a href="{{ route('karyawan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">ID User:</label>
                <input type="number" name="id_user" class="form-control" value="{{ $karyawan->id_user }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" value="{{ $karyawan->email }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama:</label>
                <input type="text" name="nama" class="form-control" value="{{ $karyawan->nama }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jabatan:</label>
                <input type="text" name="jabatan" class="form-control" value="{{ $karyawan->jabatan }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor HP:</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $karyawan->no_hp }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat:</label>
                <textarea name="alamat" class="form-control" rows="3" required>{{ $karyawan->alamat }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Masuk:</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ $karyawan->tanggal_masuk }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status:</label>
                <select name="status" class="form-control" required>
                    <option value="Aktif" {{ $karyawan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ $karyawan->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <input type="submit" name="submit"class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>
    <div>

    </div>
</div>
@endsection
