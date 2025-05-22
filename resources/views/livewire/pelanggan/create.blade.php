<div>
    <h1 class="mt-4">Kelola Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="{{ route('pelanggan.view') }}">Pelanggan</a></li>
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
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <label>Nama </label>
                    <input type="text" class="form-control" wire:model="form.nama">
                    @error('form.nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" wire:model="email">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label>No.Hp</label>
                    <input type="text" class="form-control" wire:model="form.no_hp">
                    @error('form.no_hp') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="form.keterangan"
                                id="keteranganPribadi" value="pribadi">
                            <label class="form-check-label" for="keteranganPribadi">Pribadi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="form.keterangan"
                                id="keteranganPerusahaan" value="perusahaan">
                            <label class="form-check-label" for="keteranganPerusahaan">Perusahaan</label>
                        </div>
                    </div>
                    @error('form.keterangan')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>alamat</label>
                    <textarea class="form-control" wire:model="form.alamat" id="" cols="20" rows="5"></textarea>
                    @error('form.alamat') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>
</div>
