<div class="p-6">
    <h1 class="mt-4">Manajemen Kontent</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate href="{{ route('konten.view') }}">Kontent</a></li>
        <li class="breadcrumb-item active">Update Data Konten</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">Edit Data Konten</span>
            </div>
            <div>
                <a class="btn btn-danger float-end" href="{{ route('konten.view') }}" wire:navigate>
                    <i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="update" class="space-y-4">
                <div class="mb-3">
                    <label>Judul</label>
                    <input type="text" wire:model="form.judul" class="form-control">
                    @error('form.judul') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" wire:model="form.kategori" class="form-control">
                    @error('form.kategori') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label>Isi Konten</label>
                    <textarea wire:model="form.isi" class="form-control"></textarea>
                    @error('form.isi') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Input dan preview Gambar -->
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" class="form-control" wire:model="form.foto_konten">
                    @error('form.foto_konten') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @if (is_object($form->foto_konten))
                <!-- Preview Gambar Baru -->
                <div class="mt-2">
                    <img src="{{ $form->foto_konten->temporaryUrl() }}" alt="Preview Gambar"
                        style="max-width: 300px; max-height: 200px;">
                </div>
                @elseif (!empty($form->gambar_lama))
                <!-- Preview Gambar Lama dari Database -->
                <div class="mt-2">
                    <img src="{{ asset('storage/konten/gambar/' . $form->gambar_lama) }}" alt="Gambar Lama"
                        style="max-width: 300px; max-height: 200px;">
                </div>
                @endif



                <!-- Input dan preview Video -->
                <div class="mb-3">
                    <label>Video</label>
                    <input type="file" class="form-control" wire:model="form.video_konten">
                    @error('form.video_konten') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Preview Video Baru -->
                @if ($form->video_lama)
                <div class="mt-2">
                    <video width="320" height="240" controls>
                        <source src="{{ $form->video_lama->temporaryUrl() }}">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
                @elseif (!empty($form->video_lama))
                <!-- Preview Video Lama dari Database -->
                <div class="mt-2">
                    <video width="320" height="240" controls>
                        <source src="{{ asset('storage/' . $form->video_lama) }}">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
                @endif


                <button type="submit" class="btn btn-success">Updates</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>
</div>