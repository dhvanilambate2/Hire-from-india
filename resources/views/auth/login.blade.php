@extends('layouts.app')

@section('title', 'Login')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="text-center mb-4">
            <i class="fas fa-bolt fa-2x" style="color: #4f46e5;"></i>
            <h2 class="mt-2">Welcome Back</h2>
            <p class="text-muted">Sign in to your account</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="you@example.com"
                       required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" style="color: #4f46e5; font-weight: 500; font-size: 14px;">
                    Forgot Password?
                </a>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-sign-in-alt me-2"></i> Sign In
            </button>
        </form>

        <p class="text-center text-muted mb-0">
            Don't have an account?
            <a href="{{ route('register') }}" style="color: #4f46e5; font-weight: 600;">Register here</a>
        </p>
    </div>
</div>
@endsection
