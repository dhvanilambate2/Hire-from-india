<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | Auth</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">

<main class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5">

        <div class="text-center mb-4">
            <a href="/" class="text-decoration-none fw-bold fs-4 text-dark">
                {{ config('app.name') }}
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                @yield('content')
            </div>
        </div>

    </div>
</main>

</body>
</html>
