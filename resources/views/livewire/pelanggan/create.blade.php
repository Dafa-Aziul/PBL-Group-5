<div>
    <h1 class="mt-4">Kelola Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('pelanggan.view') }}">Pelanggan</a></li>
        <li class="breadcrumb-item active">Tambah Pelanggan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data Pelanggan</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('pelanggan.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">

            <form wire:submit.prevent="simpan">
                {{-- Nama Pelanggan --}}
                <div class="mb-3">
                    <label>Nama Pelanggan</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" wire:model="form.nama">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        wire:model="form.email">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- No Telepon --}}
                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                        wire:model="form.no_hp">
                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                        wire:model="form.alamat"></textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- No Polisi --}}
                <div class="mb-3">
                    <label>No Polisi</label>
                    <input type="text" class="form-control @error('no_polisi') is-invalid @enderror"
                        wire:model="form.no_polisi">
                    @error('no_polisi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Pelanggan --}}
                <div class="mb-3">
                    <label>Jenis Kendaraan </label>
                    <select class="form-select @error('jenis_kendaraan_id') is-invalid @enderror"
                        wire:model="form.jenis_kendaraan_id">
                        <option value="">-- Pilih Jenis Kendaraan --</option>
                        @foreach ($jenis_kendaraan as $jenis)
                        <option value="{{$jenis -> id}}">{{$jenis->nama_jenis}}</option>

                        @endforeach
                    </select>
                    @error('pelanggan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Tipe Kendaraan --}}
                <div class="mb-3">
                    <label>Tipe Kendaraan</label>
                    <input type="text" class="form-control @error('tipe_kendaraan') is-invalid @enderror"
                        wire:model="form.tipe_kendaraan">
                    @error('tipe_kendaraan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Speedo Meter --}}
                <div class="mb-3">
                    <label>Speedo Meter</label>
                    <input type="text" class="form-control @error('odometer') is-invalid @enderror"
                        wire:model.defer="form.odometer">
                    @error('odometer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mb-3">
                    <label>Keterangan</label><br>
                    <label>
                        <input type="radio" wire:model="from.keterangan" value="pribadi"> Pribadi
                    </label>
                    <label class="ms-3">
                        <input type="radio" wire:model.defer="keterangan" value="perusahaan"> Perusahaan
                    </label>
                    @error('keterangan') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>
                <button class="btn btn-secondary" type="reset">Reset</button>
            </form>

        </div>
    </div>
</div>