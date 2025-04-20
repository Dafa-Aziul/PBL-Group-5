@extends( 'layouts.main' )
@section( 'title','Daftar Pelanggan' )
@section('navPelanggan','active')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Data Pelanggan</h1>
</div>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
      <h1 class="h4">Edit Data Pelanggan</h1>
      <div class="d-flex justify-content-end">
        <a href="/pelanggan" class="btn btn-primary mb-3">kembali</a>
      </div>
    </div>
    <div class="card-body">
        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Nama Pelanggan</label>
                <div class="col-sm-6">
                    <input type="text" name="nama_pelanggan" class="form-control" value="{{ $pelanggan->nama_pelanggan }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control" value="{{ $pelanggan->email }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">No Telepon</label>
                <div class="col-sm-6">
                    <input type="text" name="no_telp" class="form-control" value="{{ $pelanggan->no_telp }}" required >
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-6">
                    <textarea type="text" name="alamat" class="form-control" rows="3" required>{{ $pelanggan->alamat }}</textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">No Polisi</label>
                <div class="col-sm-6">
                    <input type="text" name="no_polisi" class="form-control" value="{{ $pelanggan->no_polisi }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Jenis Kendaraan</label>
                <div class="col-sm-6">
                    <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select">
                        <option value="">Pilih Jenis Kendaraan</option> <!-- Untuk placeholder -->
                        <option value="Mobil" {{ $pelanggan->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="Truk" {{ $pelanggan->jenis_kendaraan == 'Truk' ? 'selected' : '' }}>Truk</option>
                        <option value="Pick Up" {{ $pelanggan->jenis_kendaraan == 'Pick Up' ? 'selected' : '' }}>Pick Up</option>
                        <option value="Bus" {{ $pelanggan->jenis_kendaraan == 'Bus' ? 'selected' : '' }}>Bus</option>
                        <option value="Minibus" {{ $pelanggan->jenis_kendaraan == 'Minibus' ? 'selected' : '' }}>Minibus</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Model</label>
                <div class="col-sm-6">
                    <input type="text" name="model" class="form-control" value="{{ $pelanggan->model }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-6">
                    <label>
                        <input type="radio" name="ket" value="Pribadi"  {{ $pelanggan->ket == 'Pribadi' ? 'checked' : '' }} required> Pribadi
                    </label><br>
                    <label>
                        <input type="radio" name="ket" value="Perusahaan"  {{ $pelanggan->ket == 'Perusahaan' ? 'checked' : '' }} required> Perusahaan
                    </label><br>
                </div>
            </div>
    
            <div class="row mt-4">
                <div class="offset-sm-2 col-sm-6">
                    <button type="submit" class="btn btn-primary my-3 px-3">Simpan</button>
                </div>
                
            </div>
    
        </form>
    </div>
  </div>

@endsection

