<div>
    <h1 class="mt-4">Kelola Jenis Kendaraan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" class="text-primary text-decoration-none" href="{{ route('jenis_kendaraan.view') }}">Jenis Kendaraan</a></li>
        <li class="breadcrumb-item active">Update Jenis Kendaraan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Edit Data Kendaraan</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('jenis_kendaraan.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="mb-3">
                    <label>Nama Jenis</label>
                    <input type="text" class="form-control" wire:model="form.nama_jenis"
                    @error('form.nama_jenis') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Tipe Kendaraan</label>
                    <input type="text" class="form-control" wire:model="form.model_kendaraan" value="{{ old('form.model_kendaraan', $jenis_kendaraan->model_kendaraan)}}">
                    @error('form.model_kendaraan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Deskripsi</label>
                    <input type="text" class="form-control" wire:model="form.deskripsi"
                    @error('form.deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <button type="submit" class="btn btn-success" >Simpan</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>
</div>
