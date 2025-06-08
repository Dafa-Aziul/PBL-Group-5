<div>
    <h2 class="mt-4">Kelola Pelanggan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Pelanggan</a></li>
        <li class="breadcrumb-item active">Edit Pelanggan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Edit Data Pelanggan</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('pelanggan.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="mb-3">
                    <label>Nama </label>
                    <input type="text" class="form-control" wire:model="form.nama"
                        value="{{ old('form.nama', $pelanggan->nama)}}">
                    @error('form.nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" wire:model="email"
                        value="{{ old('email', $pelanggan->email)}}" readonly>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label>No.Hp</label>
                    <input type="text" class="form-control" wire:model="form.no_hp"
                        value="{{ old('form.no_hp', $pelanggan->no_hp)}}">
                    @error('form.no_hp')
                    <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <div class="btn-group">
                        <input type="radio" id="pribadi" value="pribadi" wire:model="form.tipe" class="btn-check">
                        <label for="pribadi" class="btn btn-outline-primary">pribadi</label>

                        <input type="radio" id="perusahaan" value="perusahaan" wire:model="form.tipe" class="btn-check">
                        <label for="perusahaan" class="btn btn-outline-primary">Perusahaan</label>
                    </div>
                    {{-- --}}
                    @error('form.keterangan')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>alamat</label>
                    <textarea class="form-control" wire:model="form.alamat" id="" cols="20"
                        rows="5">{{ old('form.alamat', $pelanggan->alamat)}}</textarea>
                    @error('form.alamat') <span class="text-danger">{{ $message }}</span> @enderror
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
