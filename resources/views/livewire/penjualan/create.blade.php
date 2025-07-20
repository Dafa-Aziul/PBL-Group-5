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
                component.set("form.pelanggan_id", $(this).val());
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
            const stok = $el.data('stok');

            const badgeClass = stok <= 10 ? 'bg-danger' : 'bg-primary';

            return $(`
                <div class="d-flex align-items-center gap-2">
                    <img src="${img}" width="75" class="rounded"/>
                    <div class="small lh-sm">
                        <div><strong>Nama:</strong> ${nama}</div>
                        <div><strong>Harga:</strong> ${harga}</div>
                        <div><strong>Tipe Kendaraan:</strong> ${tipe}</div>
                        <div>
                            <strong>Stok:</strong>
                            <span class="badge ${badgeClass}">${stok}</span>
                        </div>
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

    var modalInstance = null;

    function initModal() {
        const modalEl = document.getElementById('editJumlahModal');
        if (!modalEl) return;

        // Hapus instance lama jika ada
        if (modalInstance) {
            modalInstance.dispose();
        }

        // Buat instance baru
        modalInstance = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false
        });

        // Cleanup saat modal ditutup
        modalEl.addEventListener('hidden.bs.modal', () => {
            Livewire.dispatch('modal-closed');
        });
    }

    // Handle modal events
    window.addEventListener('open-edit-modal', () => {
        if (!modalInstance) {
            initModal();
        }
        modalInstance.show();
        setTimeout(() => document.getElementById('editJumlah')?.focus(), 50);
    });

    window.addEventListener('hide-edit-jumlah-modal', () => {
        if (modalInstance) {
            modalInstance.hide();
        }
    });
    // Ketika Livewire selesai load halaman
    document.addEventListener('livewire:load', () => {
        initModal();
        initPelangganSelect2();
        initSparepartSelect2();
    });

    // Setelah setiap update DOM Livewire, panggil lagi supaya select2 diinisialisasi ulang
    Livewire.hook('message.processed', (message, component) => {
        initPelangganSelect2();
        initSparepartSelect2();
    });

    document.addEventListener('livewire:navigated', () => {
        initModal();
        initPelangganSelect2();
        initSparepartSelect2();
    });

    window.addEventListener('reset-select2', () => {
        $('#sparepart_id').val(null).trigger('change');
    });

</script>

@endpush
<div>
    <h2 class="mt-4">Kelola Penjualan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('penjualan.view') }}">Penjualan</a></li>
        <li class="breadcrumb-item active">Input Data Penjualan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data Penjualan</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{ route('penjualan.view') }}" wire:navigate>
                    <i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form wire:submit.prevent="store">
                {{-- Pilih Pelanggan --}}
                <div class="mb-3">
                    <label>Pelanggan</label>
                    <div wire:ignore>
                        <select wire:model="form.pelanggan_id" class="form-select select2" id="pelanggan_id">
                            <option></option>
                            @foreach ($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('form.pelanggan_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Kode Transaksi</label>
                    <input wire:model="form.kode_transaksi" type="text" class="form-control">
                    @error('form.kode_transaksi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Penggunaan Sparepart --}}
                <div class="card mb-4">
                    <div class="card-header">Penggunaan Sparepart</div>
                    <div class="card-body p-3">
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
                                            data-tipe="{{ $sparepart->tipe_kendaraan }}"
                                            data-stok="{{ $sparepart->stok }}">
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

                        {{-- Tabel Sparepart --}}
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama Sparepart</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th style="width: 40px; text-align: center;">Aksi</th>
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
                                        <td>
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
                                        <th colspan="4">Total Sparepart</th>
                                        <td colspan="2">Rp {{ number_format($totalSparepart, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            @error('sparepartList')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 mb-3">
                                <label for="pajak" class="form-label">Pajak 11%</label>
                                <div class="form-control mb-1">
                                    Rp {{ number_format($this->form->pajak, 0, ',', '.')}}
                                </div>
                                @error('pajak') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 col-md-4 mb-3 ">
                                <label for="diskon">Diskon (%)</label>
                                <input type="text" min="0" max="100" class="form-control"
                                    wire:model.number.lazy="form.diskon" id="diskon" maxlength="3" max="100"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                @error('form.diskon') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6 col-md-4 mb-3">
                                <label for="diskon">Diskon (Rp)</label>
                                <div class="form-control mb-1">
                                    Rp {{ number_format($this->total_diskon, 0, ',', '.')}}
                                </div>
                                @error('') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <div class="alert alert-info d-flex align-items-center" role="alert">
                                    <i class="fas fa-calculator me-2"></i>
                                    <div>
                                        <strong>Total Estimasi Biaya:</strong>
                                        <span class="text-success fs-5 ms-2">Rp {{
                                            number_format($this->form->grand_total,
                                            0,
                                            ',', '.')
                                            }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if( $totalSparepart > 0)

                @endif

                <div class="mb-3">
                    <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                    <select class="form-select" wire:model="form.status_pembayaran" id="status_pembayaran">
                        <option value="pending">Pending</option>
                        <option value="lunas">Lunas</option>
                    </select>
                    @error('form.status_pembayaran') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" wire:model="form.keterangan" id="keterangan" rows="3"></textarea>
                    @error('form.keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
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
            <div wire:ignore.self class="modal fade" id="editJumlahModal" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="editJumlahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form wire:submit.prevent="updateJumlah">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editJumlahModalLabel">Edit Jumlah Sparepart
                                </h5>
                                <button type="button" class="btn-close" wire:click="closeEditModal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="editJumlah" class="form-label">Jumlah</label>
                                <input type="number" wire:model.defer="editJumlah" id="editJumlah" min="1"
                                    class="form-control" required>
                                @error('editJumlah') <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeEditModal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update Jumlah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
