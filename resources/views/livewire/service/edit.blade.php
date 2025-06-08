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
            <form wire:submit.prevent="update">
                {{-- Pilih Pelanggan --}}
                <div class="mb-3">
                    <label>Pelanggan</label>
                    <div  class="form-control">
                        {{ $service->kendaraan->pelanggan->nama }}
                    </div>
                    @error('pelanggan_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Pilih Kendaraan berdasarkan Pelanggan --}}
                <div class="mb-3">
                    <label>Kendaraan</label>
                    <div class="form-control">
                        {{ $service->no_polisi }} - {{ $service->tipe_kendaraan }}
                    </div>
                    @error('form.kendaraan_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Input lainnya --}}
                <div class="mb-3">
                    <label>Kode Service</label>
                    <div class="form-control">
                        {{ $service->kode_service }}
                    </div>
                    @error('kode_service') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Montir</label>
                    <select wire:model="form.montir_id" class="form-select">
                        <option value="">-- Pilih Montir --</option>
                        @foreach ($montirs as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                    @error('form.montir_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- Tambahkan field lain sesuai kebutuhan --}}
                <div class="mb-3">
                    <label>Odometer</label>
                    <input wire:model="form.odometer" type="number" class="form-control">
                    @error('form.odometer') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Deskripsi Keluhan</label>
                    <textarea wire:model="form.deskripsi_keluhan" class="form-control"></textarea>
                    @error('form.deskripsi_keluhan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select wire:model="form.status" class="form-select">
                        <option value="">-- Pilih Status --</option>
                        <option value="dalam antrian">dalam antrian</option>
                        <option value="dianalisis">dianalisis</option>
                        <option value="analisis selesai">analisis selesai</option>
                        <option value="dalam proses">dalam proses</option>
                        <option value="selesai">Selesai</option>
                        <option value="batal">Batal</option>
                    </select>

                    @error('form.status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                {{-- <div class="mb-3">
                    <label>Estimasi Harga</label>
                    <input wire:model="estimasi_harga" type="number" class="form-control">
                </div> --}}

                {{-- <div class="mb-3">
                    <label>Tanggal Mulai</label>
                    <input wire:model="tanggal_mulai_service" type="date" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Tanggal Selesai</label>
                    <input wire:model="tanggal_service" type="date" class="form-control">
                </div> --}}

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea wire:model="form.keterangan" class="form-control"></textarea>
                    @error('form.keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button class="btn btn-primary">Simpan</button>
            </form>

        </div>
    </div>
</div>
