<div>
    <h1 class="mt-4">Kelola Sparepart</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('sparepart.view') }}">Sparepart</a></li>
        <li class="breadcrumb-item active">Edit Sparepart</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Edit Data Sparepart</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('sparepart.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update">
                <div class="mb-3">
                    <label>Nama Sparepart</label>
                    <input type="text" class="form-control" wire:model="form.nama"
                        value="{{ old ('form.nama', $sparepart->nama) }}">
                    @error('form.nama_jasa') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Kode</label>
                    <input type="text" id="kode" class="form-control" value="{{ old ('form.kode', $sparepart->kode) }}"
                        disabled>
                    @error('form.kode') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Merk</label>
                    <input type="text" class="form-control" wire:model="form.merk"
                        value="{{ old ('form.merk', $sparepart->merk) }}">
                    @error('form.merk') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Satuan</label>
                    <input type="text" class="form-control" wire:model="form.satuan"
                        value="{{ old ('form.satuan', $sparepart->satuan) }}">
                    @error('form.satuan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" class="form-control" wire:model="form.stok"
                        value="{{ old ('form.stok', $sparepart->stok) }}">
                    @error('form.stok') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="text" id="harga" class="form-control"
                        value="{{ old ('form.harga', $sparepart->harga) }}" oninput="formatHargaLivewire(this)">
                    @error('form.harga') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @push('scripts')
                <script>
                    function formatHargaLivewire(el) {
                        let value = el.value.replace(/[^0-9]/g, ''); // hanya angka
                        let formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        el.value = value ? 'Rp ' + formatted : '';

                        // Update ke Livewire (akses wire:id terdekat)
                        Livewire.find(el.closest('[wire\\:id]').getAttribute('wire:id'))
                            .set('form.harga', value);
                    }
                </script>
                @endpush

                <div class="mb-3">
                    <label>Model Kendaraan</label>
                    <input type="text" class="form-control" wire:model="form.model_kendaraan"
                        value="{{ old ('form.model_kendaraan', $sparepart->model_kendaraan) }}">
                    @error('form.model_kendaraan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>



                <div class="mb-3">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" wire:model="form.ket"
                        value="{{ old ('form.ket', $sparepart->ket) }}">
                    @error('form.ket') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>
</div>