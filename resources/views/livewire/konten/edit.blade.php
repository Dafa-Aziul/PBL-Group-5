<div class="p-6">
    <h2 class="mt-4">Manajemen Kontent</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('konten.view') }}">Kontent</a></li>
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
                    <textarea id="isi-berita" wire:model="form.isi" wire:ignore.self wire:key="isi-berita"
                        class="form-control">
                    </textarea>

                    @error('form.isi') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Input dan preview Gambar -->
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" class="form-control" wire:model="form.foto_konten" accept="image/*">
                    @error('form.foto_konten') <span class="text-danger">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="form.foto_konten" class="text-muted mt-2">
                        Memuat gambar...
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Kolom Gambar Lama -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Gambar Lama</label>
                        @if (!empty($form->gambar_lama))
                        <div class="border rounded p-2 text-center" style="min-height: 220px; background: #f8f9fa;">
                            <img src="{{ asset('storage/konten/gambar/' . $form->gambar_lama) }}" alt="Gambar Lama"
                                class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                        </div>
                        @else
                        <div class="border rounded p-4 d-flex justify-content-center align-items-center text-muted"
                            style="min-height: 220px; background: #f8f9fa;">
                            <span>Tidak ada gambar lama</span>
                        </div>
                        @endif
                    </div>

                    <!-- Kolom Preview Gambar Baru -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Preview Gambar Baru</label>
                        @if (is_object($form->foto_konten))
                        <div class="border rounded p-2 text-center" style="min-height: 220px; background: #f8f9fa;">
                            <img src="{{ $form->foto_konten->temporaryUrl() }}" alt="Preview Gambar Baru"
                                class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                        </div>
                        @else
                        <div class="border rounded p-4 d-flex justify-content-center align-items-center text-muted"
                            style="min-height: 220px; background: #f8f9fa;">
                            <span>Belum ada gambar baru</span>
                        </div>
                        @endif
                    </div>
                </div>


                <!-- Input dan preview Video -->
                <div class="mb-3">
                    <label>Video</label>
                    <input type="file" class="form-control" wire:model.live="form.video_konten" accept="video/*">
                    @error('form.video_konten') <span class="text-danger">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="form.video_konten" class="text-muted mt-2">
                        Memuat video...
                    </div>
                </div>

                <div class="row mt-3">
                    <!-- Kolom Video Lama -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Video Lama</label>
                        @if (!empty($form->video_lama))
                        <div class="border rounded p-2 text-center" style="min-height: 260px; background: #f8f9fa;">
                            <video width="100%" height="240" controls>
                                <source src="{{ asset('storage/konten/video/' . $form->video_lama) }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>
                        @else
                        <div class="border rounded p-4 d-flex justify-content-center align-items-center text-muted"
                            style="min-height: 260px; background: #f8f9fa;">
                            <span>Tidak ada video lama</span>
                        </div>
                        @endif
                    </div>

                    <!-- Kolom Preview Video Baru -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Preview Video Baru</label>
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
                            <span>Belum ada video baru</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select class="form-select" wire:model='form.status'>
                        <option value="" disabled selected hidden>-- Pilih Status --</option>
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
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
        });
    }

    document.addEventListener('livewire:load', () => {
        initSummernote();

        // Set isi dari Livewire ke Summernote (saat pertama kali)
        const isiDariLivewire = @this.get('form.isi');
        $('#isi-berita').summernote('code', isiDariLivewire);
    });

    // Hook sebelum form disubmit → ambil konten Summernote dan set ke Livewire
    window.addEventListener('submit', function (e) {
        const isiSummernote = $('#isi-berita').summernote('code');
        @this.set('form.isi', isiSummernote);
    });

    Livewire.hook('message.processed', (message, component) => {
        if (!$('#isi-berita').next('.note-editor').length) {
            initSummernote();
            const isi = @this.get('form.isi');
            $('#isi-berita').summernote('code', isi);
        }
    });

    document.addEventListener('livewire:navigated', () => {
        initSummernote();
        const isi = @this.get('form.isi');
        $('#isi-berita').summernote('code', isi);
    }),{once:true};
</script>
@endpush

