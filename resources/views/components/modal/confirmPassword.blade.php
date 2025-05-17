@php
    $id = $attributes->get('id', '');
    $target = $attributes->get('target', '');
    $action = $attributes->get('action', '');
@endphp
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <form wire:submit.prevent="{{ $target }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" ></button>
                </div>
                <div class="modal-body">
                    <p>Masukkan password akun Anda untuk konfirmasi.</p>
                    <input type="password" class="form-control" wire:model="password_confirmation" placeholder="Password"  autocomplete="new-password">
                    @if (Session::has('message'))
                    <small class="text-danger">
                        {{ session('message') }}
                    </small>
                    @endif
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <div wire:loading.delay wire:targ   et="submit">
                            <span class="spinner-border spinner-border-sm" role="status"></span>
                            <span wire:loading.delay >Loading...</span>
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi & Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>    