@extends('layouts.main')
@section('container')

<h1>Edit Konten</h1>
<form action="{{ route('manajemen-konten.update', $content->id_konten) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $content->judul) }}" required>
        @error('judul')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="isi" class="form-label">Isi</label>
        <textarea name="isi" id="isi" rows="5" class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi', $content->isi) }}</textarea>
        @error('isi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $content->kategori) }}" required>
        @error('kategori')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
        <input type="date" name="tanggal_terbit" id="tanggal_terbit" class="form-control @error('tanggal_terbit') is-invalid @enderror" value="{{ old('tanggal_terbit', $content->tanggal_terbit) }}" required>
        @error('tanggal_terbit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar</label>
        @if($content->gambar)
            <div class="mb-2">
                <img src="{{ asset('storage/uploads/gambar/'.$content->gambar) }}" alt="Gambar" width="100">
            </div>
        @endif
        <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror">
        @error('gambar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="video" class="form-label">Video</label>
        @if($content->video)
            <div class="mb-2">
                <video width="320" height="240" controls>
                    <source src="{{ asset('storage/uploads/video/'.$content->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
        <input type="file" name="video" id="video" class="form-control @error('video') is-invalid @enderror">
        @error('video')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
            <option value="draft" {{ old('status', $content->status) == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="terbit" {{ old('status', $content->status) == 'terbit' ? 'selected' : '' }}>Terbit</option>
            <option value="arsip" {{ old('status', $content->status) == 'arsip' ? 'selected' : '' }}>Arsip</option>
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="penulis" class="form-label">Penulis</label>
        <input type="text" name="penulis" id="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $content->penulis) }}" required>
        @error('penulis')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
