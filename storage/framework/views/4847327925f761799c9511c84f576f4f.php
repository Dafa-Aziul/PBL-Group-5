<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['active' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['active' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $classes = ($active ?? false)
        ? 'nav-link active d-flex align-items-center'
        : 'nav-link d-flex align-items-center';

    $icon = $attributes->get('icon', '');
?>


<a <?php echo e($attributes->merge(['class' => $classes])); ?> wire:navigate wire:current="active">
    <i class="<?php echo e($icon); ?>" width="30"></i>
    <span class="ml-2"><?php echo e($slot); ?></span>
</a>
<?php /**PATH D:\Bengkel Proyek\resources\views/components/nav-link.blade.php ENDPATH**/ ?>