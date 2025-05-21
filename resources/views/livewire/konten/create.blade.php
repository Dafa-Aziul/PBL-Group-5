<div>
    <h1 class="mt-4">Manajemen Kontent</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('konten.view') }}">Kontent</a></li>
        <li class="breadcrumb-item active">Tambah Konten</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Input Data Konten</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{ route('konten.view') }}" wire:navigate>
                    <i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" class="form-control" wire:model.defer="form.judul">
                    @error('form.judul') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" class="form-control" wire:model.defer="form.kategori">
                    @error('form.kategori') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Isi Konten</label>
                    <textarea class="form-control" wire:model.defer="form.isi"></textarea>
                    @error('form.isi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" class="form-control" wire:model="form.foto_konten">
                    @error('form.foto_konten') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @if ($form->foto_konten)
                <div class="mt-2">
                    <img src="{{ $form->foto_konten->temporaryUrl() }}" alt="Preview Gambar"
                        style="max-width: 300px; max-height: 200px;">
                </div>
                @endif

                <div class="mb-3">
                    <label>Video</label>
                    <input type="file" class="form-control" wire:model="form.video_konten">
                    @error('form.video_konten') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
                @if ($form->video_konten)
                <div class="mt-2">
                    <video width="320" height="240" controls>
                        <source src="{{ $form->video_konten->temporaryUrl() }}" type="{{ $form->video->getMimeType() }}">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
                @endif

                {{-- <div class="mb-3">
                    <label>Dibuat Oleh</label>
                    <input type="text" class="form-control" wire:model.defer="form.penulis_id">
                    @error('form.penulis_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div> --}}

                <button type="submit" class="btn btn-success">Simpan</button>
            </form>
        </div>
    </div>
</div>