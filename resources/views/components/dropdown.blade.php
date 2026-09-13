@props(['align' => 'right', 'width' => '48', 'contentClasses' => ''])

<div class="dropdown">
    <div data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu {{ $align === 'right' ? 'dropdown-menu-end' : '' }}">
        {{ $content }}
    </div>
</div>
