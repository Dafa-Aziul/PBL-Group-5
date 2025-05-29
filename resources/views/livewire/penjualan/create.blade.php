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
    <h1 class="mt-4">Kelola Penjualan</h1>
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
                    <select wire:model="form.pelanggan_id" class="form-select">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }}</option>
                        @endforeach
                    </select>
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
                    <div class="card-body row align-items-end">
                        <div class="row align-items-end">
                            <div class="col-md-9">
                                <select wire:model="selectedSparepartId" class="form-select">
                                    <option value="">-- Pilih Sparepart --</option>
                                    @foreach($spareparts as $sparepart)
                                    <option value="{{ $sparepart->id }}">
                                        {{ $sparepart->nama }} - Rp {{ number_format($sparepart->harga, 0, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <input wire:model.number="jumlahSparepart" type="text" min="1" class="form-control"
                                    placeholder="Jumlah">
                            </div>

                            <div class="col-md-1">
                                <button wire:click="addSparepart" type="button"
                                    class="btn btn-primary w-100">Tambah</button>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-md-9">@error('selectedSparepartId')<div class="text-danger"
                                    style="font-size: 0.875em;">{{ $message }}</div>@enderror</div>
                            <div class="col-md-2">@error('jumlahSparepart')<div class="text-danger"
                                    style="font-size: 0.875em;">{{ $message }}</div>@enderror</div>
                            <div class="col-md-1"></div>
                        </div>

                        {{-- Tabel Sparepart --}}
                        <div class="table-responsive mt-3">
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
                                        <td wire:click="openEditModal({{ $index }})" style="cursor: pointer;">{{
                                            $sparepart['jumlah'] }}</td>
                                        <td>Rp {{ number_format($sparepart['harga'], 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($sparepart['subtotal'], 0, ',', '.') }}</td>
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

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="pajak" class="form-label">Pajak 11%</label>
                                    <div class="form-control mb-1">
                                        Rp {{ number_format($this->form->pajak, 0, ',', '.')}}
                                    </div>
                                    @error('pajak') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="diskon">Diskon (%)</label>
                                    <input type="text" min="0" max="100" class="form-control"
                                        wire:model.number.lazy="form.diskon" id="diskon" maxlength="3"
                                    @error('form.diskon') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
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
                                            <span class="text-success fs-5 ms-2">Rp {{ number_format($this->form->total,
                                                0,
                                                ',', '.')
                                            }}</span>
                                        </div>
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
                <button type="submit" class="btn btn-success w-100">
                    <i class="fa-solid fa-paper-plane me-1"></i> Simpan Transaksi
                </button>
            </form>
            <div wire:ignore.self class="modal fade" id="editJumlahModal" tabindex="-1"
                aria-labelledby="editJumlahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form wire:submit.prevent="updateJumlah">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editJumlahModalLabel">Edit Jumlah Sparepart
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="editJumlah" class="form-label">Jumlah</label>
                                <input type="number" wire:model.defer="editJumlah" id="editJumlah"
                                    min="1" class="form-control" required>
                                @error('editJumlah') <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Update Jumlah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
