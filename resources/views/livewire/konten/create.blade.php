<div>
    <h2 class="mt-4">Manajemen Kontent</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none" href="{{ route('konten.view') }}">Kontent</a></li>
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
                    <label class="form-label">Judul</label>
                    <input type="text" class="form-control" wire:model.defer="form.judul">
                    @error('form.judul') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" class="form-control" wire:model.defer="form.kategori">
                    @error('form.kategori') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Isi Konten</label>
                    <div wire:ignore>
                        <textarea id="isi-berita" class="form-control text-editor" wire:model.defer="form.isi"></textarea>
                    </div>
                    @error('form.isi') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar</label>
                    <input type="file" class="form-control" wire:model="form.foto_konten" accept="image/*">
                    @error('form.foto_konten') <span class="text-danger">{{ $message }}</span> @enderror

                    <div wire:loading wire:target="form.foto_konten" class="text-muted mt-2">
                        Memuat gambar...
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Preview Gambar</label>
                    @if (is_object($form->foto_konten))
                    <div class="border rounded p-2 text-center" style="min-height: 220px; background: #f8f9fa;">
                        <img src="{{ $form->foto_konten->temporaryUrl() }}" alt="Preview Gambar Baru"
                            class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    </div>
                    @else
                    <div class="border rounded p-4 d-flex justify-content-center align-items-center text-muted"
                        style="min-height: 220px; background: #f8f9fa;">
                        <span>Belum ada gambar diupload</span>
                    </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label>Video</label>
                    <input type="file" class="form-control" wire:model="form.video_konten"
                        accept="video/mp4,video/x-m4v,video/*">
                    @error('form.video_konten') <span class="text-danger">{{ $message }}</span> @enderror

                    <div wire:loading wire:target="form.video_konten" class="text-muted mt-2">
                        Memuat video...
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Preview Video</label>
                    @if (is_object($form->video_konten))
                    <div class="border rounded p-2 text-center" style="min-height: 260px; background: #f8f9fa;">
                        <video width="100%" height="240" controls>
                            <source src="{{ $form->video_konten->temporaryUrl() }}"
                                type="{{ $form->video_konten->getMimeType() }}">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>
                    @else
                    <div class="border rounded p-4 d-flex justify-content-center align-items-center text-muted"
                        style="min-height: 260px; background: #f8f9fa;">
                        <span>Belum ada video diupload</span>
                    </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select class="form-select" wire:model='form.status'>
                        <option value="draft">Draft</option>
                        <option value="terbit">Terbit</option>
                        <option value="arsip">Arsip</option>
                    </select>
                    @error('form.status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="row g-3">
                    <div class="col-8 col-md-3">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa-solid fa-paper-plane me-1"></i> Simpan
                        </button>
                    </div>
                    <div class="col-4 col-md-2">
                        <button type="reset" class="btn btn-warning w-100">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function initSummernote() {
        $('#isi-berita').summernote({
            height: 300,
            placeholder: 'Tulis isi berita di sini...',
            callbacks: {
                onChange: function(contents) {
                    // Mengakses properti objek, bukan array
                    @this.set('form.isi', contents);
                }
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['codeview', 'help']]
            ]   ,
        });
    }

    document.addEventListener('livewire:load', () => {
        initSummernote();
    });

    Livewire.hook('message.processed', (message, component) => {
        if (!$('#isi_berita').next('.note-editor').length) {
            initSummernote();
        }
    });

    document.addEventListener('livewire:navigated', () => {
        initSummernote();
    });
</script>
@endpush
