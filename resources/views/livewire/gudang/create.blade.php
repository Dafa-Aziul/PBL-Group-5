<div>
    <h2 class="mt-4">Kelola sparepart</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Sparepart</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Daftar Sparepart</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Detail Data Sparepart : {{ $sparepart->id }} </a></li>
        <li class="breadcrumb-item active">Tambah Log Gudang</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Tambah Log Gudang : {{ $sparepart->nama }} </span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('sparepart.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="alert alert-info">
                    Stok saat ini: <strong>{{ $sparepart->stok }}</strong>
                </div>



                 <div class="mb-3">
                    <label for="aktivitas" class="form-label">Aktivitas</label>
                    <select id="aktivitas" class="form-select" wire:model="form.aktivitas" required>
                        <option value="">-- Pilih Aktivitas --</option>
                        <option value="masuk">Masuk</option>
                        <option value="keluar">Keluar</option>
                    </select>

                    @error('form.aktivitas') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" id="jumlah" class="form-control" wire:model="form.jumlah" min="1" required>
                    @error('form.jumlah') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea id="keterangan" class="form-control" rows="3" wire:model="form.keterangan" placeholder="Tulis keterangan tambahan..."></textarea>
                    @error('form.keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>
