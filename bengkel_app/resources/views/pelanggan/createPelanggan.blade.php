@extends('layouts.main')
@section('title','Tambah Pelanggan')
@section('navPelanggan','active')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Pelanggan</h1>
</div>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
        <h1 class="h4">Daftar Pelanggan</h1>
        <div class="d-flex justify-content-end">
            <a href="/pelanggan" class="btn btn-primary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf

            {{-- Nama Pelanggan --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Nama Pelanggan</label>
                <div class="col-sm-6">
                    <input type="text" name="nama_pelanggan" class="form-control @error('nama_pelanggan') is-invalid @enderror" value="{{ old('nama_pelanggan') }}" >
                    @error('nama_pelanggan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Email --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- No Telepon --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">No Telepon</label>
                <div class="col-sm-6">
                    <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp') }}" >
                    @error('no_telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-6">
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" >{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- No Polisi --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">No Polisi</label>
                <div class="col-sm-6">
                    <input type="text" name="no_polisi" class="form-control @error('no_polisi') is-invalid @enderror" value="{{ old('no_polisi') }}" >
                    @error('no_polisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Jenis Kendaraan --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Jenis Kendaraan</label>
                <div class="col-sm-6">
                    <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select @error('jenis_kendaraan') is-invalid @enderror">
                        <option value="">Pilih Jenis Kendaraan</option>
                        <option value="Mobil" {{ old('jenis_kendaraan') == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="Truk" {{ old('jenis_kendaraan') == 'Truk' ? 'selected' : '' }}>Truk</option>
                        <option value="Pick Up" {{ old('jenis_kendaraan') == 'Pick Up' ? 'selected' : '' }}>Pick Up</option>
                        <option value="Bus" {{ old('jenis_kendaraan') == 'Bus' ? 'selected' : '' }}>Bus</option>
                        <option value="Minibus" {{ old('jenis_kendaraan') == 'Minibus' ? 'selected' : '' }}>Minibus</option>
                    </select>
                    @error('jenis_kendaraan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Model --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Model</label>
                <div class="col-sm-6">
                    <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model') }}" >
                    @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Keterangan --}}
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-6">
                    <label>
                        <input type="radio" name="ket" value="Pribadi" {{ old('ket') == 'Pribadi' ? 'checked' : '' }} > Pribadi
                    </label><br>
                    <label>
                        <input type="radio" name="ket" value="Perusahaan" {{ old('ket') == 'Perusahaan' ? 'checked' : '' }} > Perusahaan
                    </label>
                    @error('ket')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tombol Simpan & Reset --}}
            <div class="row mt-4">
                <div class="offset-sm-2 col-sm-6">
                    <button type="submit" class="btn btn-primary my-3 px-3">Simpan</button>
                    <button type="reset" name="reset" class="btn btn-warning">Reset</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
