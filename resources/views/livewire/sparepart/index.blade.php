<div>
    <h2 class="mt-4">Kelola sparepart</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('sparepart.view') }}">Jenis Sparepart</a></li>
        <li class="breadcrumb-item active">Daftar Sparepart</li>
    </ol>
    @if (session()->has('success'))
    <div class="        ">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div @elseif (session()->has('error'))
    <div class="">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fas fa-table me-1"></i>
                <span class="d-none d-md-inline ms-1 ">Daftar sparepart</span>
            </div>
            <div>
                <a class="btn btn-primary float-end" href="{{ route('sparepart.create') }}" wire:navigate><i
                        class="fas fa-plus"></i>
                    <span class="d-none d-md-inline ms-1">Tambah sparepart</span>
                </a>

            </div>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-3 d-flex justify-content-between">
                <!-- Select Entries per page -->
                <div class=" col-2 col-md-2 d-flex align-items-center">
                    <select class="form-select" wire:model.live="perPage" style="width:auto;cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                    </select>
                    <label class="d-none d-md-inline ms-2 mb-0 text-muted">Entries per page</label>
                </div>

                <!-- Search -->
                <div class="position-relative col-5 col-md-3">
                    <input type="text" class="form-control ps-5" placeholder="Search"
                        wire:model.live.debounce.100ms="search" />
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama Sparepart</th>
                            <th>Merk Sparepart</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Tipe Kendaraan</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    </tfoot>
                    <tbody>
                        @forelse ($spareparts as $sparepart)
                        <tr style="cursor: pointer;" x-data
                            @click="Livewire.navigate(`/sparepart/{{ $sparepart->id }}`)">
                            <td class="text-center">{{ ($spareparts->firstItem() + $loop->iteration) - 1 }}</td>
                            <td>{{ $sparepart->kode}}</td>
                            <td>{{ $sparepart->nama}}</td>
                            <td>{{ $sparepart->merk}}</td>
                            <td>{{ $sparepart->satuan}}</td>
                            <td>{{ $sparepart->stok }}</td>


                            <td>Rp {{ number_format($sparepart->harga, 0, ',', '.') }}
                            <td>{{ $sparepart->tipe_kendaraan}}</td>
                            <td>{{ $sparepart->ket}}</td>
                            <td class="text-center" @click.stop>
                                <img src="{{ $sparepart->foto ? asset('storage/images/sparepart/' . $sparepart->foto) : asset('storage/images/sparepart/default.png') }}"
                                    alt="Foto Sparepart" class="img-thumbnail"
                                    style="max-width: 150px; max-height: 150px; object-fit: contain;"
                                    data-bs-toggle="modal" data-bs-target="#fotoModal{{ $sparepart->id }}"
                                    style="cursor: zoom-in;">
                                <div class="modal fade" id="fotoModal{{ $sparepart->id }}" tabindex="-1"
                                    aria-labelledby="fotoModalLabel{{ $sparepart->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <!-- modal-lg untuk besar -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="fotoModalLabel{{ $sparepart->id }}">Preview
                                                    Foto Sparepart
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ $sparepart->foto ? asset('storage/' . $sparepart->foto) : asset('foto/default.png') }}"
                                                    alt="Preview Gambar" class="img-fluid rounded shadow">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center" @click.stop>
                                <a href="{{ route('sparepart.edit', ['id' => $sparepart->id]) }}"
                                    class="btn btn-warning mb-3 mb-md-2" wire:navigate>
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>

                                <!-- Button delete yang trigger modal unik -->
                                <button class="btn btn-danger mb-3 mb-md-2" data-bs-toggle="modal"
                                    data-bs-target="#confirm-{{ $sparepart->id }}">
                                    <i class="fas fa-trash-can"></i>
                                    <span class="d-none d-md-inline ms-1">Delete</span>
                                </button>

                                <!-- Modal confirm unik per item -->
                                <x-modal.confirm id="confirm-{{ $sparepart->id }}" action="modal"
                                    target="delete({{ $sparepart->id }})"
                                    content="Apakah anda yakin untuk menghapus data ini?" />
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted">Tidak ada data yang ditemukan.</td>
                        </tr>
                        @endforelse
                </table>

                <!-- Modal Preview Gambar -->
                {{-- <div class="modal fade" id="fotoModal{{ $sparepart->id }}" tabindex="-1"
                    aria-labelledby="fotoModalLabel{{ $sparepart->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <!-- modal-lg untuk besar -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="fotoModalLabel{{ $sparepart->id }}">Preview Foto Sparepart
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ $sparepart->foto ? asset('storage/' . $sparepart->foto) : asset('foto/default.png') }}"
                                    alt="Preview Gambar" class="img-fluid rounded shadow">
                            </div>
                        </div>
                    </div>
                </div> --}}

            </div>

            {{ $spareparts->links() }}
        </div>
    </div>

</div>
