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
                        readonly>
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
                        value="{{ old ('form.stok', $sparepart->stok) }}" readonly>
                    @error('form.stok') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="text" id="harga" class="form-control"
                        value="{{ old('form.harga', $sparepart->harga) }}" oninput="formatHargaLivewire(this)"
                        maxlength="13">
                    @error('form.harga') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @push('scripts')
                <script>
                    // Format langsung saat halaman edit dibuka
                    document.addEventListener('DOMContentLoaded', function () {
                        let el = document.getElementById('harga');
                        if (el && el.value) {
                            let raw = el.value.replace(/[^0-9]/g, '');
                            if (raw) {
                                el.value = 'Rp ' + raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                            } else {
                                el.value = 'Rp 0';
                            }
                        }
                    });

                    function formatHargaLivewire(el) {
                        let rawValue = el.value.replace(/[^0-9]/g, '');
                        if (!rawValue) {
                            el.value = 'Rp 0';
                            updateLivewireHarga(0);
                            return;
                        }

                        let value = rawValue.replace(/^0+(?!$)/, '');
                        let formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        el.value = 'Rp ' + formatted;

                        updateLivewireHarga(parseInt(value, 10) || 0);
                    }

                    function updateLivewireHarga(value) {
                        let rootEl = document.getElementById('harga').closest('[wire\\:id]');
                        if (rootEl) {
                            let component = Livewire.find(rootEl.getAttribute('wire:id'));
                            if (component) {
                                component.set('form.harga', value);
                            }
                        }
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