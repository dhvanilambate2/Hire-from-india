<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts (optional) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">

    <!-- Navbar -->
    @include('layouts.navigation')

    <!-- Page Header -->
    @isset($header)
        <header class="bg-white border-bottom">
            <div class="container py-3">
                <h1 class="h4 mb-0">
                    {{ $header }}
                </h1>
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main class="container py-4">
        @yield("content")
    </main>

</body>
</html>
