@push('scripts')
<script>
    window.addEventListener('hide-modal', event => {
        const modalEl = document.getElementById('stokModal');
        const modal = bootstrap.Modal.getInstance(modalEl);

        if (modal) {
            modal.hide();
        }

        // Tambahan: bersihkan backdrop jika tertinggal
        setTimeout(() => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        }, 300); // delay kecil untuk pastikan transisi selesai
    });

    // Opsional: Jika pakai Livewire, tambahkan hook
    document.addEventListener('livewire:load', function () {
        Livewire.hook('message.processed', () => {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();

            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('padding-right');
        });
    });
</script>
@endpush
<div>
    <h2 class="mt-4">Kelola sparepart</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">sparepart</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Daftar sparepart</a></li>
        <li class="breadcrumb-item active">Detail Data sparepart : {{ $sparepart->nama }}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Data sparepart</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{  route('sparepart.view') }}" wire:navigate>
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama</label>
                        <div class="form-control bg-light">{{ $sparepart->nama }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Merk</label>
                        <div class="form-control bg-light">{{ $sparepart->merk }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Satuan</label>
                        <div class="form-control bg-light">{{ $sparepart->satuan }}</div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Harga</label>
                        <div class="form-control bg-light">{{ $sparepart->harga }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipe Kendaraan</label>
                        <div class="form-control bg-light">{{ $sparepart->tipe_kendaraan }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">{{ $sparepart->ket }}</div>
                    </div>
                </div>

            </div>
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-success text-white justify-content-between d-flex align-items-center">
                    <div class="">
                        <i class="fas fa-credit-card me-2"></i>
                        <strong>log gudang</strong>
                    </div>

                    <button class="btn bg-white text-success btn-success" data-bs-toggle="modal"
                        data-bs-target="#stokModal">
                        <i class="fas fa-plus"></i>
                        <span class="d-none d-md-inline ms-1">Tambah log gudang</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>
                            <span class="badge bg-{{ $sparepart->stok <= 10 ? 'danger' : 'info' }} fs-6">
                                Stok barang : {{ $sparepart->stok }}
                            </span>
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th>Sparepart</th>
                                    <th>Aktivitas</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    {{-- <th class="text-center">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sparepart->gudangs as $index => $gudang)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $gudang->sparepart->nama ?? '-' }}</td>
                                    <td>{{ $gudang->aktivitas }}</td>
                                    <td>{{ $gudang->jumlah }}</td>
                                    <td>{{ $gudang->keterangan }}</td>
                                    {{-- <td class="text-center">
                                        <a href="" class="btn btn-warning btn-sm" wire:navigate>
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            <span class="d-none d-md-inline ms-1">Riwayat Service<s /span>
                                        </a>
                                    </td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada monitoring sparepart
                                        terdaftar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-bold mb-0">log gudang</label>
                        <a class="btn btn-primary" href="{{ route('gudang.create', ['id' => $sparepart->id]) }}"
                            wire:navigate>
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline ms-1">Tambah log gudang</span>
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#stokModal">
                            <i class="fas fa-plus"></i>
                            <span class="d-none d-md-inline ms-1">Tambah log gudang</span>
                        </button>
                    </div>


                </div>
            </div> --}}
        </div>
        <div class="modal fade" id="stokModal" tabindex="-1" aria-labelledby="stokModalLabel" aria-hidden="true"
            wire:ignore.self>
            <div class="modal-dialog">
                <form wire:submit.prevent="updateGudang" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stokModalLabel">Tambah Aktivitas Stok</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-info">
                            Stok saat ini: <strong>{{ $sparepart->stok }}</strong>
                        </div>

                        <div class="mb-3">
                            <label for="aktivitas" class="form-label">Aktivitas</label>
                            <select id="aktivitas" class="form-select" wire:model="form.aktivitas" required>
                                <option value="">-- Pilih Aktivitas --</option>
                                <option value="masuk">Masuk</option>
                                <option value="keluar">Keluar</option>
                            </select>
                            @error('form.aktivitas')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" id="jumlah" class="form-control" wire:model="form.jumlah" min="1"
                                required>
                            @error('form.jumlah') <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea id="keterangan" class="form-control" rows="3" wire:model="form.keterangan"
                                placeholder="Tulis keterangan tambahan..."></textarea>
                            @error('form.keterangan') <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
