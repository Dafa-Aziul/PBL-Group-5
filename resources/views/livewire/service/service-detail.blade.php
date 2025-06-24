@push('scripts')
<script>
    function initJasaSelect2() {
        $('#jasa_id').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Pilih --',
            allowClear: true
        }).on('change', function () {
            // Cari instance Livewire dari elemen parent dengan atribut wire:id
            const componentId = this.closest('[wire\\:id]').getAttribute('wire:id');
            const component = Livewire.find(componentId);
            if (component) {
                component.set("selectedJasaId", $(this).val());
            }
        });
    }
    function initSparepartSelect2() {
        $('#sparepart_id').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Pilih --',
            allowClear: true,
            templateResult: formatSparepartOption,
            templateSelection: formatSparepartOption
        }).on('change', function () {
            const componentId = this.closest('[wire\\:id]').getAttribute('wire:id');
            const component = Livewire.find(componentId);
            if (component) {
                component.set("selectedSparepartId", $(this).val());
            }
        });

        function formatSparepartOption(option) {
            if (!option.id) return option.text;

            const $el = $(option.element);
            const img = $el.data('image');
            const nama = $el.data('nama');
            const harga = $el.data('harga');
            const tipe = $el.data('tipe');

            return $(`
                <div class="d-flex align-items-center gap-2">
                    <img src="${img}" width="75" class="rounded"/>
                    <div class="small lh-sm">
                        <div><strong>Nama:</strong> ${nama}</div>
                        <div><strong>Harga:</strong> ${harga}</div>
                        <div><strong>Tipe Kendaraan:</strong> ${tipe}</div>
                    </div>
                </div>
            `);
        }
    }
    function initSparepartSelect2() {
        $('#sparepart_id').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '-- Pilih --',
            allowClear: true,
            templateResult: formatSparepartOption,
            templateSelection: formatSparepartSelection
        }).on('change', function () {
            const componentId = this.closest('[wire\\:id]').getAttribute('wire:id');
            const component = Livewire.find(componentId);
            if (component) {
                component.set("selectedSparepartId", $(this).val());
            }
        });

        function formatSparepartOption(option) {
            if (!option.id) return option.text;

            const $el = $(option.element);
            const img = $el.data('image');
            const nama = $el.data('nama');
            const harga = $el.data('harga');
            const tipe = $el.data('tipe');

            return $(`
                <div class="d-flex align-items-center gap-2">
                    <img src="${img}" width="75" class="rounded"/>
                    <div class="small lh-sm">
                        <div><strong>Nama:</strong> ${nama}</div>
                        <div><strong>Harga:</strong> ${harga}</div>
                        <div><strong>Tipe Kendaraan:</strong> ${tipe}</div>
                    </div>
                </div>
            `);
        }
        function formatSparepartSelection(option) {
            if (!option.id) return option.text;

            const $el = $(option.element);
            return `${$el.data('nama')} : (${$el.data('tipe')}) - ${$el.data('harga')}`;
        }
    }

    // Ketika Livewire selesai load halaman
    document.addEventListener('livewire:load', () => {
        initJasaSelect2();
        initSparepartSelect2();
    });

    // Setelah setiap update DOM Livewire, panggil lagi supaya select2 diinisialisasi ulang
    Livewire.hook('message.processed', (message, component) => {
        initJasaSelect2();
        initSparepartSelect2();
    });

    document.addEventListener('livewire:navigated', () => {
        initJasaSelect2();
        initSparepartSelect2();
    });

    window.addEventListener('reset-jasa-select2', () => {
        $('#jasa_id').val(null).trigger('change');
    });
    window.addEventListener('reset-sparepart-select2', () => {
        $('#sparepart_id').val(null).trigger('change');
    });
    window.addEventListener('open-edit-modal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('editJumlahModal'));
        myModal.show();
        Livewire.dispatch('modalOpened');
    });

    window.addEventListener('hide-edit-jumlah-modal', event => {
        var myModalEl = document.getElementById('editJumlahModal');
        var modal = bootstrap.Modal.getInstance(myModalEl);
        if (modal) {
            modal.hide();
        }
    });
</script>

@endpush
<div>
    <h2 class="mt-4">Kelola Service</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('service.view') }}">Service</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('service.view') }}">Daftar Service</a></li>
        <li class="breadcrumb-item active">Detail Data Service : {{ $service->kode_service }}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Detail Data service</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{  route('service.view') }}" wire:navigate><i
                        class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- Nama Pelanggan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pelanggan</label>
                        <div class="form-control bg-light">
                            {{ optional($service->kendaraan->pelanggan)->nama ?? '-' }}
                        </div>
                    </div>

                    <!-- Detail Kendaraan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Detail Kendaraan</label>

                        <div class="form-control bg-light mb-1">
                            <strong>No. Polisi:</strong> {{ $service->no_polisi ?? '-' }}
                        </div>

                        <div class="form-control bg-light mb-1">
                            <strong>Odometer:</strong> {{ $service->odometer ?? '-' }} km
                        </div>

                        <div class="form-control bg-light mb-1">
                            <strong>Tipe Kendaraan:</strong> {{ $service->tipe_kendaraan ?? '-' }}
                        </div>

                        <div class="form-control bg-light mb-1">
                            <strong>Jenis Kendaraan:</strong> {{
                            optional($service->kendaraan->jenis_kendaraan)->nama_jenis ?? '-' }}
                        </div>
                    </div>


                </div>

                <div class="col-md-6">
                    <!-- Montir -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Montir</label>
                        <div class="form-control bg-light">
                            {{ optional($service->montir)->nama ?? '-' }}
                        </div>
                    </div>

                    <!-- Keluhan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keluhan</label>
                        <textarea class="form-control bg-light" rows="3" readonly
                            style="overflow-y: auto; resize: none;">{{ $service->deskripsi_keluhan ?? '-' }}
                        </textarea>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">
                            {{ $service->keterangan ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            {{-- Penggunaan Jasa --}}
            <form wire:submit.prevent="simpanDetail">
                <div class="card mb-4">
                    <div class="card-header">Penggunaan Jasa</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="row g-2">
                                <div class="col-10 col-md-11">
                                    <div wire:ignore>
                                        <select wire:model.live="selectedJasaId" class="form-select select2"
                                            id="jasa_id">
                                            <option></option>
                                            @foreach($jasas as $jasa)
                                            <option value="{{ $jasa->id }}">{{ $jasa->nama_jasa }}, {{
                                                $jasa->jenisKendaraan->nama_jenis }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('selectedJasaId')
                                    <div class="text-danger" style="font-size: 0.875em;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-2 col-md-1">
                                    <button wire:click="addJasa" type="button" class="btn btn-primary w-100">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>



                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama Jasa</th>
                                        <th>Harga</th>
                                        <th style="width: 40px; padding: 0.2rem; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jasaList as $index => $jasa)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jasa['nama_jasa'] }}</td>
                                        <td>Rp {{ number_format($jasa['harga'], 0, ',', '.') }}</td>
                                        <td style="width: 40px; padding: 0.2rem; text-align: center;">
                                            <button wire:click="removeJasa({{ $index }})" type="button"
                                                class="btn btn-outline-danger p-0" style="width: 28px; height: 28px;"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt fa-xs"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada jasa yang ditambahkan</td>
                                    </tr>
                                    @endforelse
                                    @if(count($jasaList) > 0)
                                    <tr class="table-light">
                                        <th colspan="2" class="text-start">Total Jasa</th>
                                        <td colspan="2">Rp {{ number_format($totalJasa, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            @error('jasaList')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Penggunaan Sparepart</div>
                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-12 col-md-9">
                                <div wire:ignore>
                                    <select wire:model="selectedSparepartId" class="form-select select2"
                                        id="sparepart_id">
                                        <option></option>
                                        @foreach($spareparts as $sparepart)
                                        <option value="{{ $sparepart->id }}"
                                            data-image="{{ $sparepart->foto ? asset('storage/images/sparepart/' . $sparepart->foto) : asset('images/asset/default-sparepart.jpg') }}"
                                            data-nama="{{ $sparepart->nama }}"
                                            data-harga="Rp {{ number_format($sparepart->harga, 0, ',', '.') }}"
                                            data-tipe="{{ $sparepart->tipe_kendaraan }}">
                                            {{ $sparepart->nama }}, {{ $sparepart->tipe_kendaraan }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('selectedSparepartId')
                                <div class="text-danger" style="font-size: 0.875em;">{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-8 col-md-2">
                                <input wire:model.number="jumlahSparepart" type="text"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" min="1"
                                    class="form-control" placeholder="Jumlah">
                                @error('jumlahSparepart')
                                <div class="text-danger" style="font-size: 0.875em;">{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-4 col-md-1 d-flex flex-column justify-content-start align-middle">
                                <button wire:click="addSparepart" type="button" class="btn btn-primary">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama Sparepart</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th style="width: 40px; padding: 0.2rem; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sparepartList as $index => $sparepart)
                                    <tr wire:key="sparepart-{{ $sparepart['sparepart_id'] ?? 'new-'.$index }}">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $sparepart['nama'] }}</td>
                                        <td wire:click="openEditModal({{ $index }})" style="cursor: pointer;"
                                            @if($isProcessing)
                                            style="pointer-events: none; opacity: 0.6; cursor: not-allowed;" @endif>
                                            {{ $sparepart['jumlah'] }}
                                        </td>
                                        <td>Rp {{ number_format($sparepart['harga'], 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($sparepart['sub_total'], 0, ',', '.') }}</td>
                                        <td style="width: 40px; padding: 0.2rem; text-align: center;">
                                            <button wire:click="removeSparepart({{ $index }})" type="button"
                                                class="btn btn-outline-danger p-0" style="width: 28px; height: 28px;"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt fa-xs"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada sparepart yang ditambahkan</td>
                                    </tr>
                                    @endforelse
                                    @if(count($sparepartList))
                                    <tr class="table-light">
                                        <th colspan="4" class="text-start">Total Sparepart</th>
                                        <td colspan="2">Rp {{ number_format($totalSparepart, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
                @if($totalJasa > 0 || $totalSparepart > 0)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <i class="fas fa-calculator me-2"></i>
                        Estimasi Total Service
                    </div>
                    <div class="card-body bg-light">
                        <div class="mb-3 d-flex align-items-center">
                            <i class="fas fa-money-bill-wave me-2 text-success fs-5"></i>
                            <h5 class="mb-0">
                                Total Biaya:
                                <strong class="text-dark">Rp {{ number_format($totalSemua, 0, ',', '.') }}</strong>
                            </h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-stopwatch me-2 text-primary fs-5"></i>
                            <h5 class="mb-0">
                                Estimasi Waktu:
                                <strong class="text-dark">{{ $estimasiWaktuReadable }}</strong>
                            </h5>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Tombol Submit --}}
                <div class="text-end mb-4">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan Service
                        & Detail</button>
                </div>
            </form>
            <!-- Modal Edit Jumlah Sparepart -->
            <div wire:ignore.self class="modal fade" id="editJumlahModal" tabindex="-1"
                aria-labelledby="editJumlahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form wire:submit.prevent="updateJumlah">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editJumlahModalLabel">Edit Jumlah Sparepart</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="editJumlah" class="form-label">Jumlah</label>
                                <input type="number" wire:model.defer="editJumlah" id="editJumlah" min="1"
                                    class="form-control" required>
                                @error('editJumlah') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update Jumlah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
