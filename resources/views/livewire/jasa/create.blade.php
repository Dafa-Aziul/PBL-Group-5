<div>
    <h2 class="mt-4">Kelola Jenis Jasa</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item" ><a wire:navigate class="text-primary text-decoration-none" href="{{ route('jasa.view') }}">Jenis Jasa</a></li>
        <li class="breadcrumb-item active">Tambah Jenis Jasa</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data Jasa</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('jasa.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit">
                <div class="mb-3">
                    <label>Nama Jasa</label>
                    <input type="text" class="form-control" wire:model="form.nama_jasa">
                    @error('form.nama_jasa') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Kode</label>
                    <input type="text" id="kode" class="form-control" oninput="formatKodeLivewire(this)">
                    @error('form.kode') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @push('scripts')
                <script>

                function formatKodeLivewire(el) {
                    let raw = el.value.replace(/^JS-?/i, '').replace(/[^a-zA-Z0-9]/g, ''); // hanya alphanumeric
                    let formatted = 'JS-' + raw.toUpperCase(); // pastikan huruf besar
                    el.value = formatted;
                    Livewire.find(el.closest('[wire\\:id]').getAttribute('wire:id'))
                        .set('form.kode', formatted);
                }
                </script>
                @endpush



                <div class="mb-3">
                    <label>Jenis Kendaraan </label>
                    <select class="form-select @error('form.jenis_kendaraan_id') is-invalid @enderror"
                        wire:model="form.jenis_kendaraan_id">
                        <option value="" disabled selected hidden>-- Pilih Jenis Kendaraan --</option>
                        @foreach ($jenis_kendaraan as $jenis)
                        <option value="{{$jenis->id}}">{{$jenis->nama_jenis}}</option>
                        @endforeach
                    </select>
                    @error('form.jenis_kendaraan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>



                <div class="mb-3">
                    <label>Estimasi Pengerjaan</label>
                    <input type="time" class="form-control" wire:model="form.estimasi">
                    @error('form.estimasi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @if ($form->estimasi)
                @php
                $parts = explode(':', $form->estimasi);
                $jam = (int) ($parts[0] ?? 0);
                $menit = (int) ($parts[1] ?? 0);
                @endphp
                <p class="text-muted mt-1 d-block">
                    Estimasi: {{ $jam }} jam {{ $menit }} menit
                </p>
                @endif

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
                    <label>Keterangan</label>
                    <input type="text" class="form-control" wire:model="form.keterangan">
                    @error('form.keterangan') <span class="text-danger">{{ $message }}</span> @enderror
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
