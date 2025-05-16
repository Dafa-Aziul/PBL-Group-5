<div>
    <h1 class="mt-4">Kelola Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Pelanggan</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Daftar Pelanggan</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Detail Data Pelanggan : {{ $pelanggan->id }} </a></li>
        <li class="breadcrumb-item active">Detail Data Pelanggan : </li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Tambah Kendaraan Pelanggan : {{ $pelanggan->nama }} </span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('pelanggan.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <label for="jenis_kendaraan_id" class="form-label">Jenis Kendaraan</label>
                    <select wire:model="form.jenis_kendaraan_id" class="form-select">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach ($jenis_kendaraans as $jenis)
                        <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis}}</option>
                        @endforeach
                    </select>
                    @error('form.jenis_kendaraan_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">No Polisi</label>
                    <input type="text" wire:model="form.no_polisi" class="form-control">
                    @error('form.no_polisi') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe Kendaraan</label>
                    <input type="text" wire:model="form.tipe_kendaraan" class="form-control">
                    @error('form.tipe_kendaraan') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Odometer</label>
                    <input type="number" wire:model="form.odometer" class="form-control">
                    @error('form.odometer') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>