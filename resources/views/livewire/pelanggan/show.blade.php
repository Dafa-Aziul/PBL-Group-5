@push('scripts')
<script>
    window.addEventListener('open-modal', event => {
        const modalEl = document.getElementById('formModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });

    // Menangani penutupan modal
    window.addEventListener('hide-modal', event => {
        const modalEl = document.getElementById('formModal');
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
    <h2 class="mt-4">Kelola Pelanggan</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Pelanggan</a></li>
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('pelanggan.view') }}">Daftar Pelanggan</a></li>
        <li class="breadcrumb-item active">Detail Data Pelanggan : {{ $pelanggan->nama }}</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1">Data Pelanggan</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{  route('pelanggan.view') }}" wire:navigate>
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
                        <div class="form-control bg-light">{{ $pelanggan->nama }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <div class="form-control bg-light">{{ $pelanggan->email }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No HP</label>
                        <div class="form-control bg-light">{{ $pelanggan->no_hp }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat</label>
                        <div class="form-control bg-light">{{ $pelanggan->alamat }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan</label>
                        <div class="form-control bg-light">{{ $pelanggan->keterangan }}</div>
                    </div>
                </div>
            </div>
            <div class="card mt-4 shadow-sm border-0">
                <div class="card-header bg-primary text-white justify-content-between d-flex align-items-center">
                    <div class="">
                        <i class="fas fa-car me-2"></i>
                        <strong>Daftar Kendaraan</strong>
                    </div>
                    @can('admin')
                    <button class="btn bg-white text-primary btn-primary" data-bs-toggle="modal"
                        data-bs-target="#formModal">
                        <i class="fas fa-plus"></i>
                        <span class="d-none d-md-inline ms-1">Tambah Kendaraan</span>
                    </button>
                    @endcan
                </div>
                <div class="card-body">
                    @if (session()->has('success'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                        class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @elseif (session()->has('error'))
                    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th>No.</th>
                                    <th>No Polisi</th>
                                    <th>Jenis Kendaraan</th>
                                    <th>Tipe</th>
                                    <th>Odometer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pelanggan->kendaraans as $index => $kendaraan)
                                <tr style="cursor:pointer;" wire:x-data
                                    @click="Livewire.navigate(`/pelanggan/{{ $pelanggan->id }}/kendaraan/{{ $kendaraan->id }}`)">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $kendaraan->no_polisi }}</td>
                                    <td>{{ $kendaraan->jenis_kendaraan->nama_jenis ?? '-' }}</td>
                                    <td>{{ $kendaraan->tipe_kendaraan }}</td>
                                    <td>{{ $kendaraan->odometer }} km</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada kendaraan terdaftar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="formModal" tabindex="-1"
            aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="createKendaraan">
                        <div class="modal-header">
                            <h5 class="modal-title" id="formModalLabel">Form Kendaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="jenis_kendaraan_id" class="form-label">Jenis Kendaraan</label>
                                <select wire:model="form.jenis_kendaraan_id" class="form-select">
                                    <option value="" disabled selected hidden>-- Pilih Jenis --</option>
                                    @foreach ($jenis_kendaraans as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                    @endforeach
                                </select>
                                @error('form.jenis_kendaraan_id') <div class="text-danger">{{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No Polisi</label>
                                <input type="text" wire:model="form.no_polisi" class="form-control">
                                @error('form.no_polisi') <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tipe Kendaraan</label>
                                <input type="text" wire:model="form.tipe_kendaraan" class="form-control">
                                @error('form.tipe_kendaraan') <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Odometer</label>
                                <input type="number" wire:model="form.odometer" class="form-control">
                                @error('form.odometer') <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
