@extends('layouts.app')

@section('title', 'Reset Password')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="text-center mb-4">
            <div style="width:80px;height:80px;border-radius:50%;background:#dcfce7;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-lock-open fa-2x" style="color:#16a34a;"></i>
            </div>
            <h2>Reset Password</h2>
            <p class="text-muted">Enter your new password below.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $email) }}"
                       required readonly>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">New Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 8 characters"
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                       class="form-control"
                       placeholder="Repeat new password"
                       required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-save me-2"></i> Reset Password
            </button>
        </form>

        <p class="text-center text-muted mb-0">
            <a href="{{ route('login') }}" style="color: #4f46e5; font-weight: 600;">
                <i class="fas fa-arrow-left me-1"></i> Back to Login
            </a>
        </p>
    </div>
</div>
@endsection
