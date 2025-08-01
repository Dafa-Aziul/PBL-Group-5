<div>
    <h2 class="mt-4">Kelola Sparepart</h2>
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
            <form wire:submit.prevent="submit"enctype="multipart/form-data">
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
                    <label>Tipe Kendaraan</label>
                    <input type="text" class="form-control" wire:model="form.tipe_kendaraan">
                    @error('form.tipe_kendaraan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" wire:model="form.foto" accept="image/png, image/jpeg">
                    @error('form.foto') <span class="text-danger">{{ $message }}</span> @enderror

                    {{-- Loading saat upload gambar --}}
                    <div wire:loading wire:target="form.foto" class="text-muted mt-2">
                        Memuat gambar...
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Preview Gambar</label>

                    @if (is_object($form->foto))
                        <div class="border rounded p-2 text-center" style="min-height: 220px; background: #f8f9fa; position: relative;">
                            {{-- Loading indicator di atas preview --}}
                            <div wire:loading wire:target="form.foto" class="position-absolute top-50 start-50 translate-middle text-primary">
                                <div class="spinner-border spinner-border-sm" role="status"></div>
                                <span class="ms-2">Memuat preview...</span>
                            </div>

                            <img src="{{ $form->foto->temporaryUrl() }}" alt="Preview Gambar Baru"
                                class="img-fluid rounded" style="max-height: 200px; object-fit: contain;"
                                wire:loading.remove>
                        </div>
                    @else
                        <div class="border rounded p-4 d-flex justify-content-center align-items-center text-muted"
                            style="min-height: 220px; background: #f8f9fa;">
                            <span>Belum ada foto diupload</span>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" wire:model="form.ket">
                    @error('form.ket') <span class="text-danger">{{ $message }}</span> @enderror
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
