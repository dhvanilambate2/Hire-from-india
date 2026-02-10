@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">

    <h1 class="mb-3">
        {{ config('app.name', 'Laravel') }}
    </h1>

    <p class="text-muted mb-4">
        Welcome to your application
    </p>

    <div class="d-flex justify-content-center gap-3">
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                Login
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-primary">
                    Register
                </a>
            @endif
        @endauth
    </div>

</div>
@endsection
