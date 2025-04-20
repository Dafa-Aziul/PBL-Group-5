@extends( 'layouts.main' )
@section( 'title','Management User' )
@section('navUser','active')
@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Management User</h1>
</div>
<divc class="card mb-3">
  <div class="card-header d-flex justify-content-between align-items-center p-3">
    <h1 class="h4">Daftar User</h1>
    <div class="d-flex justify-content-end">
      <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah User</a>
    </div>
  </div>
  <div class="card-body">
  <table class="table table-hover">
    <thead class="table table-primary">
      <tr class="text-md-cente">
        <th scope="col">No.</th>
        <th scope="col">Nama</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($users as $user)
        <tr class="">
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role }}</td>
          <td>
            {{-- <a href="/user/{{ $user->id }}/edit" class="badge bg-warning"><span data-feather="edit">Edit</span></a> --}}
            <form action="/user/{{ $user->id }}" method="POST" class="d-inline">
              @csrf
              @method('delete')
              <button class="badge bg-danger border-0" onclick="return confirm('Yakin ingin menghapus?')">
                <span data-feather="x-circle">Delete</span></button>
            </form>
          </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Data pelanggan belum ada.</td>
        </tr>
        @endforelse
        @if(session('success') || session('gagal'))
          <script>
              alert("{{ session('success') ?? session('gagal') }}");
          </script>
        @endif
    </tbody>
  </table>
  </div>
  
</div>
@endsection