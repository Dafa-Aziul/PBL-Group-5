<?php
    $target = $attributes->get('target', '');
    $id = $attributes->get('id', '');
    $targetModal = $attributes->get('targetModal', '');
    $action = $attributes->get('action', '');
    $content = $attributes->get('content', '');
?>
<div class="modal fade" id="<?php echo e($id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><?php echo e($content); ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" data-bs-toggle="<?php echo e($action); ?>"  wire:click="<?php echo e($target); ?>" data-bs-target="#<?php echo e($targetModal); ?>" data-bs-dismiss="modal" class="btn btn-primary">Ya</button>
        </div>
      </div>
    </div>
</div><?php /**PATH D:\Bengkel Proyek\resources\views/components/modal/confirm.blade.php ENDPATH**/ ?>