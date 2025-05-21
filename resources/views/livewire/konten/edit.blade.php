<div class="p-6">
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
        
                <div class="mb-3">
                    <label>URL Gambar</label>
                    <input type="text" wire:model="form.gambar_url" class="form-control">
                </div>
        
                <div class="mb-3">
                    <label>URL Video</label>
                    <input type="text" wire:model="form.video_url" class="form-control">
                </div>
        
        
                <div class="mb-3">
                    <label>Dibuat Oleh</label>
                    <input type="text" wire:model="form.penulis_id" class="form-control">
                    @error('form.penulis_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
        
                <button type="submit" class="btn btn-success" >Updates</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </form>
        </div>
    </div>
</div>