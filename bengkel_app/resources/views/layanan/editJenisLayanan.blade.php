@extends( 'layouts.main' )
@section( 'title','Edit Jenis Layanan' )
@section('navLayanan','active')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Jenis Layanan</h1>
</div>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center p-3">
      <h1 class="h4">Edit Data Jenis Layanan</h1>
      <div class="d-flex justify-content-end">
        <a href="/layanan" class="btn btn-primary mb-3">kembali</a>
      </div>
    </div>
    <div class="card-body">
        <form action="{{ route('layanan.update', $jenislayanan->id ) }}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Nama Layanan</label>
                <div class="col-sm-6">
                    <input type="text" name="nama_layanan" class="form-control" value="{{ $jenislayanan->nama_layanan }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Estimasi Pengerjaan</label>
                <div class="col-sm-6">
                    <input type="text" name="estimasi_pengerjaan" class="form-control" value="{{ $jenislayanan->estimasi_pengerjaan }}"required>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Jenis Kendaraan</label>
                <div class="col-sm-6">
                    <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-select">
                        <option value="">Pilih Jenis Kendaraan</option> <!-- Untuk placeholder -->
                        <option value="Mobil" {{ $jenislayanan->jenis_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="Truk" {{ $jenislayanan->jenis_kendaraan == 'Truk' ? 'selected' : '' }}>Truk</option>
                        <option value="Pick Up" {{ $jenislayanan->jenis_kendaraan == 'Pick Up' ? 'selected' : '' }}>Pick Up</option>
                        <option value="Bus" {{ $jenislayanan->jenis_kendaraan == 'Bus' ? 'selected' : '' }}>Bus</option>
                        <option value="Minibus" {{ $jenislayanan->jenis_kendaraan == 'Minibus' ? 'selected' : '' }}>Minibus</option>
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Harga</label>
                <div class="col-sm-6">
                    <input type="text" name="harga" id="harga" class="form-control" value="{{ $jenislayanan->harga }}"required>
                </div>
            </div>

            <script>
                // Fungsi untuk format harga dengan simbol Rp
                function formatHarga(value) {
                    // Hapus semua karakter selain angka
                    value = value.replace(/[^\d]/g, '');
                
                    // Format angka dengan pemisah ribuan
                    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                
                    // Menambahkan simbol Rp di depan
                    return value ? 'Rp ' + value : '';
                }
                
                // Fungsi untuk menangani input
                document.getElementById('harga').addEventListener('input', function(e) {
                    let value = e.target.value;
                
                    // Menghapus karakter selain angka dan simbol Rp
                    value = value.replace(/[^0-9]/g, ''); // Menghapus karakter selain angka
                
                    // Format harga untuk tampilan
                    e.target.value = formatHarga(value);
                });
                
                // Menangani event form submit untuk mengirim harga tanpa simbol Rp dan titik
                document.querySelector('form').addEventListener('submit', function() {
                    let hargaInput = document.getElementById('harga');
                    // Menghapus simbol Rp dan titik pemisah ribuan
                    let hargaValue = hargaInput.value.replace(/[^\d]/g, '');
                    hargaInput.value = hargaValue; // Mengupdate input untuk pengiriman
                });
            </script>

            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-6">
                    <textarea type="text" name="deskripsi" class="form-control" rows="3" required>{{ $jenislayanan->deskripsi }}</textarea>
                </div>
            </div>

            
    
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

