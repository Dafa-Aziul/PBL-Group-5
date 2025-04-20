@extends( 'layouts.main' )
@section( 'title','Management Sparepart' )
@section('navSparepart','active')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Management Sparepart</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share </button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
    </div>
</div>
<div class="card mb-3">
  <div class="card-header d-flex justify-content-between align-items-center p-3">
    <h1 class="h4">Daftar Sparepart</h1>
    <div class="d-flex justify-content-end">
      <a href="/sparepart/create" class="btn btn-primary">Tambah Sparepart</a>
    </div>
  </div>
  <div class="card-body">
  <table class="table table-hover">
    <thead>
      <tr class="text-md-cente">
        <th scope="col">No.</th>
        <th scope="col">Nama Sparepart</th>
        <th scope="col">Stok</th>
        <th scope="col">Harga</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($spareparts as $sparepart)
      <tr class="">
        <th scope="row">{{ $loop->iteration }}</th>
        <td>{{ $sparepart->nama }}</td>
        <td>{{ $sparepart->stok }}</td>
        <td>Rp {{ number_format($sparepart->harga, 0, ',', '.') }}</td>
        <td>
          <a href="/sparepart/{{ $sparepart->id }}/edit" class="badge bg-warning"><span data-feather="edit">Edit</span></a>
          <form action="/sparepart/{{ $sparepart->id }}" method="POST" class="d-inline">
            @csrf
            @method('delete')
            <button class="badge bg-danger border-0" onclick="return confirm('Yakin ingin menghapus?')"><span data-feather="x-circle">Delete</span></button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
</div>
@endsection