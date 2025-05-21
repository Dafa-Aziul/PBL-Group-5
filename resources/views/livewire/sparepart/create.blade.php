<div>
    <h1 class="mt-4">Kelola Sparepart</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="{{ route('sparepart.view') }}">Sparepart</a></li>
        <li class="breadcrumb-item active">Tambah Sparepart</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data Sparepart</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('sparepart.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <label>Nama Sparepart</label>
                    <input type="text" class="form-control" wire:model.="form.nama">
                    @error('form.nama') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Kode</label>
                    <input type="text" id="kode" wire:model="kode" class="form-control"
                        oninput="formatKodeLivewire(this)">
                    @error('kode')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @push('scripts')
                <script>
                    function formatKodeLivewire(el) {
                    let raw = el.value.replace(/^SPR-?/i, '').replace(/[^a-zA-Z0-9]/g, ''); // hanya alphanumeric
                    let formatted = 'SPR-' + raw.toUpperCase(); // pastikan huruf besar
                    el.value = formatted;
                    Livewire.find(el.closest('[wire\\:id]').getAttribute('wire:id')).set('kode', formatted);
                }
                </script>
                @endpush

                <div class="mb-3">
                    <label>Merk</label>
                    <input type="text" class="form-control" wire:model="form.merk">
                    @error('form.merk') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Satuan</label>
                    <input type="text" class="form-control" wire:model="form.satuan">
                    @error('form.satuan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" class="form-control" wire:model.defer="form.stok" min="0" value="0"
                        oninput="formatStok(this)">
                    @error('form.stok') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @push('scripts')
                <script>
                    function formatStok(el) {
                        // Hilangkan nol di depan (kecuali jika cuma '0')
                        let value = el.value.replace(/^0+(?!$)/, '');

                        // Kalau kosong, set jadi 0
                        if (value === '') {
                            value = '0';
                        }

                        el.value = value;

                        // Update Livewire secara manual (optional jika butuh)
                        let rootEl = el.closest('[wire\\:id]');
                        if (rootEl) {
                            let component = Livewire.find(rootEl.getAttribute('wire:id'));
                            if (component) {
                                component.set('form.stok', parseInt(value));
                            }
                        }
                    }
                </script>
                @endpush


                <div class="mb-3">
                    <label>Harga</label>
                    <input type="text" id="harga" class="form-control" oninput="formatHargaLivewire(this)"
                        maxlength="13">
                    @error('form.harga')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                @push('scripts')
                <script>
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

                        // Set nilai ke Livewire
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
                    <input type="text" class="form-control" wire:model="form.model_kendaraan">
                    @error('form.model_kendaraan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>



                <div class="mb-3">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" wire:model="form.ket">
                    @error('form.ket') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>
</div>
