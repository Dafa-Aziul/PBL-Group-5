<div>
    <h1 class="mt-4">Detail Pengunaan Service</h1>
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
                            <strong>Model Kendaraan:</strong> {{ $service->model_kendaraan ?? '-' }}
                        </div>

                        <div class="form-control bg-light mb-1">
                            <strong>Jenis Kendaraan:</strong> {{ optional($service->kendaraan)->jenis ?? '-' }}
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
                        <div class="row align-items-end mb-3">
                            <div class="col-md-6">
                                <select wire:model.live="selectedJasaId" class="form-select">
                                    <option value="">-- Pilih Jasa --</option>
                                    @foreach($jasas as $jasa)
                                    <option value="{{ $jasa->id }}">{{ $jasa->nama_jasa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button wire:click="addJasa" type="button" class="btn btn-primary w-100">Tambah</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama Jasa</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jasaList as $index => $jasa)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jasa['nama_jasa'] }}</td>
                                        <td>Rp {{ number_format($jasa['harga'], 0, ',', '.') }}</td>
                                        <td>
                                            <button wire:click="removeJasa({{ $index }})" type="button"
                                                class="btn btn-danger btn-sm">Hapus</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada jasa yang ditambahkan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Penggunaan Sparepart</div>
                    <div class="card-body row align-items-end">
                        <div class="col-md-6">
                            <select wire:model="selectedSparepartId" class="form-select">
                                <option value="">-- Pilih Sparepart --</option>
                                @foreach($spareparts as $sparepart)
                                <option value="{{ $sparepart->id }}">
                                    {{ $sparepart->nama }} - Rp {{ number_format($sparepart->harga, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                            @error('selectedSparepartId') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-3">
                            <input wire:model="jumlahSparepart" type="number" min="1" class="form-control"
                                placeholder="Jumlah">
                            @error('jumlahSparepart') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-3">
                            <button wire:click="addSparepart" type="button"
                                class="btn btn-primary w-100">Tambah</button>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>No</th>
                                        <th>Nama Sparepart</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sparepartList as $index => $sparepart)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $sparepart['nama'] }}</td>
                                        <td>{{ $sparepart['jumlah'] }}</td>
                                        <td>Rp {{ number_format($sparepart['harga'], 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($sparepart['subtotal'], 0, ',', '.') }}</td>
                                        <td>
                                            <button wire:click="removeSparepart({{ $index }})" type="button"
                                                class="btn btn-danger btn-sm">Hapus</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada sparepart yang ditambahkan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <div class="text-end mb-4">
                    <button type="submit" class="btn btn-success">💾 Simpan Service & Detail</button>
                </div>
            </form>

        </div>
    </div>