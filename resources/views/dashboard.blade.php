<x-app-layout>
    <x-slot name="header">
        <h4 class="fw-semibold mb-0">{{ __('Dashboard') }}</h4>
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-0">{{ __("You're logged in!") }}</p>
        </div>
    </div>
</x-app-layout>
