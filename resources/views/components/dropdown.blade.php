@props(['align' => 'end'])

@php
    $alignment = match ($align) {
        'left' => 'dropdown-menu-start',
        'right' => 'dropdown-menu-end',
        default => 'dropdown-menu-end',
    };
@endphp

<div class="dropdown">
    {{-- Trigger --}}
    <div data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>

    {{-- Menu --}}
    <div class="dropdown-menu {{ $alignment }}">
        {{ $content }}
    </div>
</div>
