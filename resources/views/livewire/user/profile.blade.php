@push('scripts')
<script>
    // Gunakan namespace untuk menghindari redeclaration
    if (!window.profileCropper) {

        window.profileCropper = {
            cropper: null,
            modalEl: null,
            init: function() {
                document.addEventListener('DOMContentLoaded', () => {
                    this.setupEventListeners();
                });
            },
            setupEventListeners: function() {
                // Open cropper modal
                window.addEventListener('open-cropper-modal', () => {
                    this.modalEl = document.getElementById('cropPhotoModal');
                    const modal = new bootstrap.Modal(this.modalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });

                    this.modalEl.addEventListener('shown.bs.modal', () => {
                        const image = document.getElementById('cropperImage');
                        if (image && image.src) {
                            if (this.cropper) this.cropper.destroy();

                            this.cropper = new Cropper(image, {
                                aspectRatio: 1,
                                viewMode: 1,
                                autoCropArea: 1,
                                responsive: true,
                                restore: false,
                                checkCrossOrigin: false
                            });
                        }
                    });

                    modal.show();
                });

                // Close cropper modal
                window.addEventListener('close-cropper-modal', () => {
                    const modal = bootstrap.Modal.getInstance(this.modalEl);
                    if (modal) modal.hide();

                    setTimeout(() => {
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();

                        document.body.classList.remove('modal-open');
                        document.body.style.removeProperty('padding-right');
                    }, 300);

                    if (this.cropper) {
                        this.cropper.destroy();
                        this.cropper = null;
                    }

                    const livewireComponent = Livewire.find('{{ $this->getId() }}');
                    if (livewireComponent) {
                        livewireComponent.call('closeModal');
                    }
                });

                // Save button handler
                const cropSaveBtn = document.getElementById('cropSaveBtn');
                if (cropSaveBtn) {
                    cropSaveBtn.addEventListener('click', () => {
                        if (!this.cropper) {
                            console.error('Cropper tidak ada');
                            return;
                        }

                        const canvas = this.cropper.getCroppedCanvas({
                            width: 500,
                            height: 500,
                            minWidth: 256,
                            minHeight: 256,
                            maxWidth: 1024,
                            maxHeight: 1024,
                            fillColor: '#fff',
                            imageSmoothingEnabled: true,
                            imageSmoothingQuality: 'high'
                        });

                        if (!canvas) {
                            console.error('Canvas tidak ada');
                            return;
                        }

                        canvas.toBlob((blob) => {
                            if (!blob) {
                                console.error('Gagal membuat blob');
                                return;
                            }

                            const reader = new FileReader();
                            reader.onloadend = () => {
                                const livewireComponent = Livewire.find('{{ $this->getId() }}');
                                if (livewireComponent) {
                                    livewireComponent.call('saveCroppedPhoto', reader.result);
                                }
                            };
                            reader.readAsDataURL(blob);
                        }, 'image/png', 0.95);
                    });
                }

                // File input handler
                const input = document.getElementById('photoInput');
                if (input) {
                    input.addEventListener('change', function(e) {
                        if (e.target.files && e.target.files.length > 0) {
                            const file = e.target.files[0];

                            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                            const maxSizeMB = 2;

                            if (!allowedTypes.includes(file.type)) {
                                e.target.value = ''; // reset file input
                                return;
                            }

                            if (file.size > maxSizeMB * 1024 * 1024) {
                                e.target.value = ''; // reset file input
                                return;
                            }

                            // Jika lolos validasi JS, baru kirim event untuk buka modal
                            window.dispatchEvent(new CustomEvent('open-cropper-modal'));
                        }
                    });
                }
            }
        };

        window.profileCropper.init();
    }
</script>
@endpush

<div>
    <h2 class="mt-4">Profile Menu</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a wire:navigate class="text-primary text-decoration-none"
                href="{{ route('user.view') }}">Profile</a></li>
        <li class="breadcrumb-item active">Detail User</li>
    </ol>
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
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="card mb-4">
                <div class="card-header justify-content-between d-flex align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        <span class="d-none d-md-inline ms-1">Foto Profil</span>
                    </div>
                    <div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center mt-2">
                        <div class="position-relative d-inline-block">
                            <img src="{{ auth()->user()->profile_photo
                                ? asset('storage/images/profile/' . auth()->user()->profile_photo)
                                : asset('images/user/default.jpg') }}"
                                onerror="this.src='{{ asset('images/user/default.jpg') }}';" alt="Foto Karyawan"
                                width="200" height="200" class="rounded-circle border mb-3">


                            <!-- Tombol Edit -->
                            <a href="#" onclick="event.preventDefault(); document.getElementById('photoInput').click();"
                                class="btn btn-sm btn-warning position-absolute bottom-0 end-0 translate-middle rounded-circle"
                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-camera"></i>
                            </a>

                            {{-- <a href="#"
                                onclick="event.preventDefault(); document.getElementById('photoInput').click();"
                                class="btn btn-warning">Upload Foto</a> --}}

                        </div>
                        <input type="file" id="photoInput" wire:model="photo" style="display:none" accept="image/*"
                            max="2048000">
                        @error('photo')
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                            x-transition:leave.duration.300ms class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                        @enderror
                        <!-- Modal Cropper Foto Profil -->
                        <div wire:ignore.self class="modal fade" id="cropPhotoModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 95vw;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Crop Foto Profil</h5>
                                        <button type="button" class="btn-close" aria-label="Close"
                                            onclick="window.dispatchEvent(new CustomEvent('close-cropper-modal'))"></button>
                                    </div>

                                    <!-- Loading overlay -->
                                    <div wire:loading wire:target="photo,croppedImage" class="text-center mt-2">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <div class="modal-body d-flex justify-content-center align-items-center flex-column"
                                        style="padding: 1rem;">
                                        @if ($photo)
                                        <div class="w-100" style="max-width: 450px;">
                                            <img id="cropperImage" src="{{ $photo->temporaryUrl() }}"
                                                class="img-fluid rounded shadow-sm"
                                                style="max-height: 60vh; object-fit: contain;" alt="Preview Foto">
                                        </div>
                                        @else
                                        <p class="text-muted">Tidak ada foto untuk dicrop.</p>
                                        @endif

                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="window.dispatchEvent(new CustomEvent('close-cropper-modal'))">Batal</button>
                                        <button type="button" class="btn btn-primary" id="cropSaveBtn">
                                            <span wire:loading.remove wire:target="saveCroppedPhoto">Simpan</span>
                                            <span wire:loading wire:target="saveCroppedPhoto"
                                                class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5>{{ auth()->user()->name }}</h5>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <p class="text-muted">{{ auth()->user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card mb-4">
                <div class="card-header justify-content-between d-flex align-items-center">
                    <div>
                        <i class="fas fa-table me-1"></i>
                        <span class="d-none d-md-inline ms-1">Data User</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">Name</label>
                        <div class="col-sm-9 col-form-label">
                            {{ auth()->user()->karyawan->nama }}
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">Jabatan</label>
                        <div class="col-sm-9 col-form-label">
                            {{ auth()->user()->karyawan->jabatan }}
                        </div>
                    </div>

                    @if(auth()->user()->karyawan->no_hp)
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">Phone</label>
                        <div class="col-sm-9 col-form-label">
                            {{ auth()->user()->karyawan->no_hp }}
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->karyawan->alamat)
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">Alamat</label>
                        <div class="col-sm-9 col-form-label">
                            {{ auth()->user()->karyawan->alamat }}
                        </div>
                    </div>
                    @endif

                    @if(auth()->user()->karyawan->tgl_masuk)
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">Tanggal Masuk</label>
                        <div class="col-sm-9 col-form-label">
                            {{ \Carbon\Carbon::parse(auth()->user()->karyawan->tgl_masuk)->format('d M Y') }}
                        </div>
                    </div>
                    @endif

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-bold">Status</label>
                        <div class="col-sm-9 col-form-label">
                            <span
                                class="badge {{ auth()->user()->karyawan->status == 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst(auth()->user()->karyawan->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
