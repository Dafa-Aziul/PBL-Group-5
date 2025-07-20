@push('scripts')
<script>
    window.livewireComponentId = @json($this->getId());
</script>
<script>
    if (!window.profileCropper) {
        window.profileCropper = {
            cropper: null,
            modalEl: null,
            _eventSetup: false,

            init: function () {
                this.setupEventListeners();
            },

            setupEventListeners: function () {
                if (this._eventSetup) return;
                this._eventSetup = true;

                // Buka modal
                window.addEventListener('open-cropper-modal', () => {
                    // Sebelum membuka modal
                    document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('padding-right');

                    this.modalEl = document.getElementById('cropPhotoModal');
                    const modal = new bootstrap.Modal(this.modalEl, {
                        backdrop: 'static',
                        keyboard: false
                    });

                    this.modalEl.addEventListener('shown.bs.modal', () => {
                        const image = document.getElementById('cropperImage');
                        if (!image || !image.src) {
                            return;
                        }

                        if (image.complete) {
                            this.initCropper(image);
                        } else {
                            image.onload = () => this.initCropper(image);
                        }
                    });

                    modal.show();
                });

                // Tutup modal
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

                    const livewireComponent = Livewire.find(window.livewireComponentId);
                    if (livewireComponent) {
                        livewireComponent.call('closeModal');
                    }
                });

                // Simpan foto
                const cropSaveBtn = document.getElementById('cropSaveBtn');
                if (cropSaveBtn) {
                    cropSaveBtn.addEventListener('click', () => {
                        if (!this.cropper) {
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
                            return;
                        }

                        canvas.toBlob((blob) => {
                            if (!blob) {
                                return;
                            }

                            const reader = new FileReader();
                            reader.onloadend = () => {
                                const livewireComponent = Livewire.find(window.livewireComponentId);
                                if (livewireComponent) {
                                    livewireComponent.call('saveCroppedPhoto', reader.result);
                                }
                            };
                            reader.readAsDataURL(blob);
                        }, 'image/png', 0.95);
                    });
                }
            },

            initCropper: function (image) {
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
        };

        window.profileCropper.init();
    }

    // Re-inisialisasi saat komponen Livewire diupdate
    document.addEventListener("livewire:load", function () {
        if (window.profileCropper) {
            window.profileCropper._eventSetup = false;
            window.profileCropper.init();
        }
    });

    Livewire.hook('message.processed', () => {
        if (window.profileCropper) {
            window.profileCropper._eventSetup = false;
            window.profileCropper.init();
        }
    });
    document.addEventListener("livewire:navigated", function () {
        if (window.profileCropper) {
            window.profileCropper._eventSetup = false;
            window.profileCropper.init();
        }
    });

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
                        <i class="fa-solid fa-id-badge"></i>
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

                                    <div class="modal-body d-flex justify-content-center align-items-center flex-column"
                                        style="padding: 1rem;">
                                        @if ($photo)
                                        <div class="w-100" style="max-width: 450px;">
                                            <img id="cropperImage" src="{{ $photo->temporaryUrl() }}"
                                                class="img-fluid rounded shadow-sm"
                                                style="max-height: 60vh; object-fit: contain;" alt="Preview Foto">
                                        </div>
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
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-1">{{ auth()->user()->email }}</p>
                        <p class="text-muted mb-0">Last change: {{ auth()->user()->updated_at->format('d M Y') }}</p>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-user me-2"></i>
                        <span class="d-none d-md-inline">Informasi Pengguna</span>
                    </div>
                </div>
                <div class="card-body px-4 py-4">
                    @php $karyawan = auth()->user()->karyawan; @endphp

                    {{-- Nama --}}
                    <div class="row mx-0 py-2 border-bottom">
                        <label class="col-sm-4 fw-semibold text-muted">Nama</label>
                        <div class="col-sm-8">{{ $karyawan->nama }}</div>
                    </div>

                    {{-- Jabatan --}}
                    <div class="row mx-0 py-2 border-bottom">
                        <label class="col-sm-4 fw-semibold text-muted">Jabatan</label>
                        <div class="col-sm-8">{{ $karyawan->jabatan }}</div>
                    </div>

                    {{-- Dynamic Fields --}}
                    @foreach (['no_hp' => 'No. HP', 'alamat' => 'Alamat', 'tgl_masuk' => 'Tanggal Masuk'] as $field =>
                    $label)
                    @if (!empty($karyawan->$field))
                    <div class="row mx-0 py-2 border-bottom">
                        <label class="col-sm-4 fw-semibold text-muted">{{ $label }}</label>
                        <div class="col-sm-8">
                            {{ $field === 'tgl_masuk' ? \Carbon\Carbon::parse($karyawan->tgl_masuk)->format('d M Y') :
                            $karyawan->$field }}
                        </div>
                    </div>
                    @endif
                    @endforeach

                    {{-- Status --}}
                    <div class="row mx-0 py-2">
                        <label class="col-sm-4 fw-semibold text-muted">Status</label>
                        <div class="col-sm-8">
                            <span
                                class="badge {{ $karyawan->status === 'aktif' ? 'bg-success' : 'bg-secondary' }} text-capitalize">
                                {{ $karyawan->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
