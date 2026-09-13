@props([
    'name',
    'show' => false,
    'maxWidth' => 'md'
])

@php
$maxWidthClass = match ($maxWidth) {
    'sm' => 'modal-sm',
    'lg' => 'modal-lg',
    'xl' => 'modal-xl',
    default => '',
};
@endphp

<div class="modal fade" id="modal-{{ $name }}" tabindex="-1" aria-hidden="true"
     x-data="{ show: @js($show) }"
     x-init="
        if (show) { new bootstrap.Modal($el).show(); }
        $watch('show', val => {
            const m = bootstrap.Modal.getOrCreateInstance($el);
            val ? m.show() : m.hide();
        });
     "
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
     x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
     x-on:close.stop="show = false"
>
    <div class="modal-dialog {{ $maxWidthClass }}">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
