{{-- resources/views/auth/register.blade.php --}}

@extends('layouts.app')

@section('title', 'Register')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 520px;">
        <div class="text-center mb-4">
            <i class="fas fa-bolt fa-2x" style="color: #4f46e5;"></i>
            <h2 class="mt-2">Create Account</h2>
            <p class="text-muted">Join as a Freelancer or Employer</p>
        </div>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            {{-- Role Selection --}}
            <div class="mb-3 role-selector">
                <label class="form-label fw-semibold">I want to join as</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role"
                           id="freelancer" value="freelancer"
                           {{ old('role', 'freelancer') == 'freelancer' ? 'checked' : '' }}>
                    <label class="form-check-label" for="freelancer">
                        <i class="fas fa-laptop-code me-2"></i>
                        <strong>Freelancer</strong>
                        <small class="d-block text-muted">I want to find work</small>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role"
                           id="employer" value="employer"
                           {{ old('role') == 'employer' ? 'checked' : '' }}>
                    <label class="form-check-label" for="employer">
                        <i class="fas fa-building me-2"></i>
                        <strong>Employer</strong>
                        <small class="d-block text-muted">I want to hire talent</small>
                    </label>
                </div>
                @error('role')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="John Doe" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email Address</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="you@example.com" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Phone <small class="text-muted">(optional)</small></label>
                <input type="text" name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}"
                       placeholder="+1 234 567 890">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Min. 8 characters" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="form-control"
                       placeholder="Repeat password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-user-plus me-2"></i> Create Account
            </button>
        </form>

        <p class="text-center text-muted mb-0">
            Already have an account?
            <a href="{{ route('login') }}" style="color: #4f46e5; font-weight: 600;">Sign in</a>
        </p>
    </div>
</div>
@endsection