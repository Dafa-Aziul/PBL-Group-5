<div>
    <h1 class="mt-4">Kelola Karyawan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('karyawan.view') }}">Karyawan</a></li>
        <li class="breadcrumb-item active">Tambah Karyawan</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data Karyawan</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{ route('karyawan.view') }}" wire:navigate>
                    <i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <label>User</label>
                    <select class="form-select" wire:model.live="form.user_id">
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('form.user_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" class="form-control" wire:model.defer="form.nama" value="" readonly>
                    @error('form.nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Jabatan</label>
                    <input type="text" class="form-control" wire:model="form.jabatan">
                    @error('form.jabatan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>No Hp</label>
                    <input type="text" class="form-control" wire:model="form.no_hp">
                    @error('form.no_hp') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" class="form-control" wire:model="form.alamat">
                    @error('form.alamat') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Tanggal Masuk</label>
                    <input type="date" class="form-control" wire:model="form.tgl_masuk">
                    @error('form.tgl_masuk') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label><br>

                    <input type="radio" id="aktif" value="aktif" wire:model="form.status">
                    <label for="aktif">Aktif</label>

                    <input type="radio" id="tidakaktif" value="tidak aktif" wire:model="form.status">
                    <label for="tidakaktif">Tidak Aktif</label>

                    @error('form.status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" wire:model="form.foto">
                    @error('form.foto') <span class="text-danger">{{ $message }}</span> @enderror

                    @if ($form->foto instanceof \Livewire\TemporaryUploadedFile)
                        <img src="{{ $form->foto->temporaryUrl() }}" class="mt-2" width="100">
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-warning" wire:click="resetForm">Reset</button>
            </form>
        </div>
    </div>
</div>
