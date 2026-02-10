@props(['active' => false])

@php
    $classes = $active ? 'nav-link active' : 'nav-link';
@endphp

<a
    {{ $attributes->merge([
        'class' => $classes,
        'aria-current' => $active ? 'page' : false,
    ]) }}
>
    {{ $slot }}
</a>
