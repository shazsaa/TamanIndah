<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Taman Indah') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @include('partials.theme-assets')
    @include('partials.storefront-styles')
</head>
<body class="guest-storefront d-flex flex-column min-vh-100">
    <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center py-4 px-3">
        <div class="card guest-auth-card">
            <div class="card-body p-4">
                <h2 class="guest-brand text-center mb-4">Taman Indah</h2>
                {{ $slot }}
            </div>
        </div>
    </div>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
