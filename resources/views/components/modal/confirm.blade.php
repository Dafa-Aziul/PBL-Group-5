@php
    $target = $attributes->get('target', '');
    $id = $attributes->get('id', '');
    $targetModal = $attributes->get('targetModal', '');
    $action = $attributes->get('action', '');
    $content = $attributes->get('content', '');
@endphp
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>{{ $content }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" data-bs-toggle="{{ $action }}" data-bs-target="#{{ $targetModal }}" wire:click="{{ $target }}" class="btn btn-primary">Ya</button>
        </div>
      </div>
    </div>
</div>