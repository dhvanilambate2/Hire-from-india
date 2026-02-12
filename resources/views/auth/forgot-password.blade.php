@extends('layouts.app')

@section('title', 'Forgot Password')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="text-center mb-4">
            <div style="width:80px;height:80px;border-radius:50%;background:#fef3c7;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-key fa-2x" style="color:#d97706;"></i>
            </div>
            <h2>Forgot Password?</h2>
            <p class="text-muted">No worries! Enter your email and we'll send you a reset link.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
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

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-paper-plane me-2"></i> Send Reset Link
            </button>
        </form>

        <p class="text-center text-muted mb-0">
            Remember your password?
            <a href="{{ route('login') }}" style="color: #4f46e5; font-weight: 600;">Back to Login</a>
        </p>
    </div>
</div>
@endsection
