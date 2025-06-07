@props(['active' => false])

@php
    $classes = ($active ?? false)
        ? 'nav-link active d-flex align-items-center mt-1'
        : 'nav-link d-flex align-items-center mt-1';

    $icon = $attributes->get('icon', '');
@endphp


<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate wire:current="active">
    <i class="{{ $icon }}" width="30"></i>
    <span class="ml-2">{{ $slot }}</span>
</a>
