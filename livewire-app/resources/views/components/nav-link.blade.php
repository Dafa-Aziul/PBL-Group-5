@props(['active' => false])

@php
    $classes = ($active ?? false)
        ? 'nav-link active d-flex align-items-center'
        : 'nav-link d-flex align-items-center';

    $icon = $attributes->get('icon', '');
@endphp


<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate wire:current="active">
    <div class="sb-nav-link-icon d-flex align-items-center justify-content-center">
        <i class="{{ $icon }}" width="30"></i>
    </div>
    <span class="ml-2">{{ $slot }}</span>
</a>
