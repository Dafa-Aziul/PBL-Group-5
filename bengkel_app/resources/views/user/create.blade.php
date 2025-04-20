@extends( 'layouts.main' )
@section( 'title','Management User' )
@section(  'navUser','active')
@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Management Sparepart</h1>
    </div>
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center p-3">
            <h1 class="h4">Tambah Sparepart</h1>
            <div class="d-flex justify-content-end">
            <a href="{{ route('user.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" class="">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name User</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>         
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror   
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>         
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select @error('role') is-invalid @enderror" aria-label="Default select example" name="role" id="role" required>
                        <option {{ old('role') == '' ? 'selected' : '' }}>Pilih role</option>
                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="montir"{{ old('role') == 'montir' ? 'selected' : '' }}>montir</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <input type="submit" name="submit"class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-warning ms-2" value="Batal">
                </div>
            </form>
        </div> 
    </div> 
@endsection