@push('scripts')
<script>
    window.addEventListener('open-edit-modal', event => {
        var myModal = new bootstrap.Modal(document.getElementById('editJumlahModal'));
        myModal.show();
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
                                    <select wire:model.live="selectedJasaId" class="form-select">
                                        <option value="">-- Pilih Jasa --</option>
                                        @foreach($jasas as $jasa)
                                        <option value="{{ $jasa->id }}">{{ $jasa->nama_jasa }}</option>
                                        @endforeach
                                    </select>
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
                                <select wire:model="selectedSparepartId" class="form-select">
                                    <option value="">-- Pilih Sparepart --</option>
                                    @foreach($spareparts as $sparepart)
                                    <option value="{{ $sparepart->id }}">
                                        {{ $sparepart->nama }} - Rp {{ number_format($sparepart->harga, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
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
                                        <td wire:click="openEditModal({{ $index }})" style="cursor: pointer;">
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
                <div class="card mb-4">
                    <div class="card-header">Estimasi Total Biaya</div>
                    <div class="card-body">
                        <h5>Total Keseluruhan: <strong>Rp {{ number_format($totalSemua, 0, ',', '.') }}</strong></h5>
                    </div>
                </div>
                @endif
                {{-- Tombol Submit --}}
                <div class="text-end mb-4">
                    <button type="submit" class="btn btn-success">💾 Simpan Service & Detail</button>
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
