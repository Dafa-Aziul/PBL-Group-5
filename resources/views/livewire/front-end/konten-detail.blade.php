<div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                {{-- Kategori dan Tanggal --}}
                <div class="mb-2 text-uppercase text-primary fw-semibold">
                    {{ ucfirst($konten->kategori) }}
                </div>
                <h1 class="display-5 fw-bold mb-3">{{ $konten->judul }}</h1>
                <p class="text-muted mb-4">
                    Dipublikasikan pada {{ \Carbon\Carbon::parse($konten->created_at)->translatedFormat('d F Y') }}
                    oleh <strong>{{ $konten->penulis->nama ?? 'Admin' }}</strong>
                </p>

                {{-- Media (Video atau Gambar) --}}
                @if ($konten->video_konten)
                <div class="ratio ratio-16x9 mb-4">
                    <video controls class="rounded shadow-sm">
                        <source src="{{ asset('storage/konten/video/' . $konten->video_konten) }}" type="video/mp4">
                        Browser Anda tidak mendukung video.
                    </video>
                </div>
                @elseif ($konten->foto_konten)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/konten/gambar/' . $konten->foto_konten) }}"
                        class="img-fluid rounded shadow-sm"
                        style="max-width: 700px; width: 100%; height: auto; object-fit: cover;" alt="Foto konten">
                </div>
                @endif

                {{-- Isi Konten --}}
                <article class="content fs-5 lh-lg text-dark" style="text-align: justify;">
                    {!! $konten->isi !!}
                </article>

                {{-- Garis pemisah --}}
                <hr class="my-5">

                {{-- Info Penulis --}}
                <div class="d-flex align-items-center">
                    <img src="{{ $konten->penulis && $konten->penulis->user && $konten->penulis->user->profile_photo
                    ? asset('storage/images/profile/' . $konten->penulis->user->profile_photo)
                    : asset('storage/images/profile/default-avatar.png') }}" alt="Penulis"
                        class="rounded-circle shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $konten->penulis->nama ?? 'Admin' }}</h6>
                        <small class="text-muted">Penulis Konten</small>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>