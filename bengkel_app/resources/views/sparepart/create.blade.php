@extends( 'layouts.main' )
@section( 'title','Management Sparepart' )
@section('navSparepart','active')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Management Sparepart</h1>
</div>
<div class="card mb-3">
  <div class="card-header d-flex justify-content-between align-items-center p-3">
    <h1 class="h4">Tambah Sparepart</h1>
    <div class="d-flex justify-content-end">
      <a href="/sparepart" class="btn btn-primary">Kembali</a>
    </div>
  </div>
  <div class="card-body">
    <form action="{{ route('sparepart.store') }}" method="POST" class="">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Sparepart</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required autofocus>         
            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror   
        </div>
        <div class="mb-3">
            <label for="merk" class="form-label">Merk</label>
            <input type="text" class="form-control @error('merk') is-invalid @enderror" id="merk" name="merk" value="{{ old('merk') }}" required autofocus>         
            @error('merk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror   
        </div>
        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan') }}" required>         
            @error('satuan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok') }}" required>         
            @error('stok')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" required>
            @error('harga')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
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
        
        <div class="mb-3">
            <label for="model_kendaraan" class="form-label">Model Kendaraan</label>
            <input type="text" class="form-control @error('model_kendaraan') is-invalid @enderror" id="model_kendaraan" name="model_kendaraan" value="{{ old('model_kendaraan') }}" required>         
            @error('model_kendaraan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>         
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="d-flex justify-content-end mb-3">
            <input type="submit" name="submit"class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-warning ms-2" value="Batal">
        </div>
    </form>
  </div> 
</div> 
@endsection