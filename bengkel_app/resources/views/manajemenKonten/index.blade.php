@extends('layouts.main')
@section( 'title','Management Konten' )
@section('navKonten','active')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Management Konten</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <div class="btn-group me-2">
      <button type="button" class="btn btn-sm btn-outline-secondary">Share </button>
      <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
    </div>
  </div>
</div>
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center p-3">
    <h1 class="h4 m-0">Daftar Konten</h1>
    <a href="{{ route('manajemen_konten.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah Konten
    </a>
  </div>

  <div class="card-body">

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table table-hover align-middle text-center">
        <thead class="table-primary">
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal Terbit</th>
            <th>Gambar</th>
            <th>Video</th>
            <th>Status</th>
            <th>Penulis</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($contents as $content)
          <tr>
            <td>{{ $loop->iteration + ($contents->currentPage() - 1) * $contents->perPage() }}</td>
            <td>{{ $content->judul }}</td>
            <td>{{ $content->kategori }}</td>
            <td>{{ $content->tanggal_terbit }}</td>
            <td>
              @if($content->gambar)
                <img src="{{ asset('storage/uploads/gambar/'.$content->gambar) }}" alt="Gambar" width="100">
              @else
                -
              @endif
            </td>
            <td>
              @if($content->video)
                <video width="160" height="120" controls>
                  <source src="{{ asset('storage/uploads/video/'.$content->video) }}" type="video/mp4">
                  Your browser does not support video.
                </video>
              @else
                -
              @endif
            </td>
            <td>{{ $content->status }}</td>
            <td>{{ $content->penulis }}</td>
            <td>
              <a href="{{ route('manajemen_konten.edit', $content->id_konten) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i>
              </a>
              <form action="{{ route('manajemen_konten.destroy', $content->id_konten) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus konten ini?')">
                  <i class="bi bi-trash-fill"></i>
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center">Data konten belum ada.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $contents->links() }}
    </div>

  </div>
</div>

@endsection
