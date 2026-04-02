<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light" style="min-height: 100vh;">
    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="w-100" style="max-width: 450px;">
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold mb-3">{{ config('app.name', 'Laravel') }}</h1>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
