<div>
    <h2 class="mt-4">Kelola Absensi</h2>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a wire:navigate class="text-primary text-decoration-none" href="{{ route('absensi.view') }}">
                Absensi
            </a>
        </li>

        <li class="breadcrumb-item active">{{ ucfirst($type) }}</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header justify-content-between d-flex align-items-center">
            <div>
                <i class="fa-solid fa-clipboard-user"></i>
                <span class="d-none d-md-inline ms-1">
                    @if ($type === 'check-in')
                    Absen Masuk
                    @elseif ($type === 'check-out')
                    Absen Keluar
                    @else
                    Ketidakhadiran Karyawan
                    @endif
                </span>
            </div>
            <div>
                <a class="btn btn-danger" href="{{ route('absensi.view') }}" wire:navigate>
                    <i class="fas fa-xmark"></i>
                </a>
            </div>
        </div>


        <div class="card-body">
            <h2 class="text-xl font-semibold mb-4">
                {{ $karyawan->nama }} - {{ ucfirst($type) }}
            </h2>

            @if (!in_array($type, ['check-in', 'check-out']))
            <!-- Input file biasa untuk selain check-in/out -->
            <div class="mb-3">
                <label for="foto" class="form-label">Bukti Tidak Hadir</label>
                <input type="file" class="form-control" id="foto" wire:model="form.bukti_tidak_hadir"
                    accept="image/png, image/jpeg">
                @error('form.bukti_tidak_hadir') <span class="text-danger">{{ $message }}</span> @enderror

                {{-- Loading saat upload gambar --}}
                <div wire:loading wire:target="form.foto" class="text-muted mt-2">
                    Memuat gambar...
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Preview Gambar</label>

                @if (is_object($form->bukti_tidak_hadir))
                <div class="border rounded p-2 text-center"
                    style="min-height: 220px; background: #f8f9fa; position: relative;">
                    {{-- Loading indicator di atas preview --}}
                    <div wire:loading wire:target="form.foto"
                        class="position-absolute top-50 start-50 translate-middle text-primary">
                        <div class="spinner-border spinner-border-sm" role="status"></div>
                        <span class="ms-2">Memuat preview...</span>
                    </div>

                    <img src="{{ $form->bukti_tidak_hadir->temporaryUrl() }}" alt="Preview Gambar Baru"
                        class="img-fluid rounded" style="max-height: 200px; object-fit: contain;" wire:loading.remove>
                </div>
                @else
                <div class="border rounded p-4 d-flex justify-content-center align-items-center text-muted"
                    style="min-height: 220px; background: #f8f9fa;">
                    <span>Belum ada foto diupload</span>
                </div>
                @endif
            </div>


            @else
            <video id="camera" autoplay class="w-full rounded mb-4" style="max-width: 100%; height: auto;"></video>
            <canvas id="snapshot" class="d-none"></canvas>

            <div class="mb-4">
                <a class="btn btn-primary" onclick="takePicture()">
                    <i class="fas fa-camera"></i>
                    <span class="d-none d-md-inline ms-1">Ambil Foto</span>
                </a>
            </div>

            @if ($type === 'check-in' && $form->foto_masuk)
            <div class="mb-4">
                <img src="{{ $form->foto_masuk->temporaryUrl() }}" class="rounded w-100">
            </div>
            @elseif ($type === 'check-out' && $form->foto_keluar)
            <div class="mb-4">
                <img src="{{ $form->foto_keluar->temporaryUrl() }}" class="rounded w-100">
            </div>
            @endif




            @endif

            <form wire:submit.prevent="submit">
                @if (!in_array($type, ['check-in', 'check-out']))
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select wire:model="form.status" class="form-select">
                        <option value="" selected hidden>-- Pilih Status Tidak Hadir --</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" wire:model="form.keterangan">
                    @error('form.keterangan') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @endif

                <input type="file" id="fotoInput"
                    wire:model="{{ $type === 'check-in' ? 'form.foto_masuk' : 'form.foto_keluar' }}" class="d-none"
                    accept="image/*" capture="environment">

                @error($type === 'check-in' ? 'form.foto_masuk' : 'form.foto_keluar')
                <span class="text-danger text-sm d-block mb-2">{{ $message }}</span>
                @enderror



                <button type="submit" class="btn btn-success me-2" wire:loading.attr="disabled">
                    <span wire:loading.remove><i class="fas fa-save"></i> Simpan</span>
                    <span wire:loading><i class="fas fa-spinner fa-spin"></i> Menyimpan...</span>
                </button>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <button type="reset" class="btn btn-warning" onclick="window.location.reload();">
                    <i class="fas fa-rotate-right"></i> Reset
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
@if ($type === 'check-in' || $type === 'check-out')
<script>
    const canvas = document.getElementById('snapshot');
    const input = document.getElementById('fotoInput');
    let streamRef = null;

    function startCamera() {
        const video = document.getElementById('camera');
        if (!video) return;

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                streamRef = stream;
            })
            .catch(e => alert('Tidak bisa akses kamera: ' + e.message));
    }

    function stopCamera() {
        if (streamRef) {
            streamRef.getTracks().forEach(track => track.stop());
            streamRef = null;
        }
    }

    function takePicture() {
        const video = document.getElementById('camera');
        if (!video) return;

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(blob => {
            const file = new File([blob], "absen.jpg", { type: "image/jpeg" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            input.files = dataTransfer.files;
            input.dispatchEvent(new Event('change', { bubbles: true }));

            @this.upload('{{ $type === "check-in" ? "form.foto_masuk" : "form.foto_keluar" }}', file,
                (success) => console.log("Upload sukses!"),
                (error) => console.error("Upload gagal:", error)
            );
        }, 'image/jpeg');
    }

    // Start kamera pertama kali saat halaman pertama kali dimuat
    startCamera();

    // Stop kamera sebelum keluar/navigasi
    window.addEventListener('beforeunload', stopCamera);
    document.addEventListener('livewire:navigating', stopCamera);

    // Start kamera ulang setelah kembali ke halaman ini
    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => startCamera(), 100); // delay kecil agar video element siap
    });
</script>
@endif
@endpush


