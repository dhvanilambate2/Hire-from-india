@props(['active' => false])

@php
    $classes = $active
        ? 'list-group-item list-group-item-action active'
        : 'list-group-item list-group-item-action';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
