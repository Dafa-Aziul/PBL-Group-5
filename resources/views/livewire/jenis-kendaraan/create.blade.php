<div>
    <h2 class="mt-4">Kelola Jenis Kendaraan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('jenis_kendaraan.view') }}">Jenis Kendaraan</a></li>
        <li class="breadcrumb-item active">Tambah Jenis Kendaraan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data Kendaraan</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('jenis_kendaraan.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <label>Nama Jenis</label>
                    <input type="text" class="form-control" wire:model="form.nama_jenis">
                    @error('form.nama_jenis') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Tipe Kendaraan</label>
                    <input type="text" class="form-control" wire:model="form.tipe_kendaraan">
                    @error('form.tipe_kendaraan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" wire:model="form.deskripsi">
                    @error('form.deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row g-3">
                    <div class="col-8 col-md-3">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa-solid fa-paper-plane me-1"></i> Simpan
                        </button>
                    </div>
                    <div class="col-4 col-md-2">
                        <button type="reset" class="btn btn-warning w-100">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
