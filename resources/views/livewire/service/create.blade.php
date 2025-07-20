@push('scripts')
<script>
    function initPelangganSelect2() {
            $('#pelanggan_id').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: '-- Pilih --',
                allowClear: true
            }).on('change', function () {
                // Cari instance Livewire dari elemen parent dengan atribut wire:id
                const componentId = this.closest('[wire\\:id]').getAttribute('wire:id');
                const component = Livewire.find(componentId);
                if (component) {
                    component.set("pelanggan_id", $(this).val());
                }
            });
        }
        // Ketika Livewire selesai load halaman
        document.addEventListener('livewire:load', () => {
            initPelangganSelect2();
        });

        // Setelah setiap update DOM Livewire, panggil lagi supaya select2 diinisialisasi ulang
        Livewire.hook('message.processed', (message, component) => {
            initPelangganSelect2();
        });

        document.addEventListener('livewire:navigated', () => {
            initPelangganSelect2();
        });
</script>
@endpush
<div>
    <h2 class="mt-4">Kelola Service</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('service.view') }}">service</a></li>
        <li class="breadcrumb-item active">Tambah service</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data service</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('service.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="store">
                {{-- Pilih Pelanggan --}}
                <div class="mb-3">
                    <label>Pelanggan</label>
                    <div wire:ignore>
                        <select wire:model="pelanggan_id" class="form-select select2" id="pelanggan_id">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('pelanggan_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Pilih Kendaraan berdasarkan Pelanggan --}}
                <div class="mb-3">
                    <label>Kendaraan</label>
                    <select wire:model.live="form.kendaraan_id" class="form-select" @disabled(!$pelanggan_id)>
                        <option value="">-- Pilih Kendaraan --</option>
                        @forelse ($kendaraans as $k)
                        <option value="{{ $k->id }}">{{ $k->no_polisi }} - {{ $k->tipe_kendaraan }}</option>
                        @empty
                        <option disabled>Tidak ada kendaraan ditemukan</option>
                        @endforelse
                    </select>
                    @error('form.kendaraan_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Input lainnya --}}
                <div class="mb-3">
                    <label>Kode Service</label>
                    <div class="form-control"> {{ $kode_service }}</div>
                    @error('kode_service') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Montir</label>
                    <select wire:model="form.montir_id" class="form-select">
                        <option value="" selected hidden>-- Pilih Montir --</option>
                        @foreach ($montirs as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                    @error('form.montir_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Tambahkan field lain sesuai kebutuhan --}}
                <div class="mb-3">
                    <label>Odometer</label>
                    <input wire:model="form.odometer" type="number" class="form-control"
                        placeholder="{{ $selectedKendaraan?->odometer ? 'Terakhir: ' . $selectedKendaraan->odometer . ' Km' : 'Masukkan odometer sekarang' }}">
                    @error('form.odometer') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Deskripsi Keluhan</label>
                    <textarea wire:model="form.deskripsi_keluhan" class="form-control"></textarea>
                    @error('form.deskripsi_keluhan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea wire:model="form.keterangan" class="form-control"></textarea>
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
