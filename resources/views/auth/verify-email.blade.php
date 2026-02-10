{{-- resources/views/auth/verify-email.blade.php --}}

@extends('layouts.app')

@section('title', 'Verify Email')

@section('body')
<div class="auth-wrapper">
    <div class="auth-card text-center">
        <div class="mb-4">
            <div style="width:80px;height:80px;border-radius:50%;background:#eef2ff;margin:0 auto;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-envelope fa-2x" style="color: #4f46e5;"></i>
            </div>
        </div>

        <h2>Verify Your Email</h2>
        <p class="text-muted mb-4">
            We've sent a verification link to <strong>{{ auth()->user()->email }}</strong>.
            Please check your inbox and click the link to verify.
        </p>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100 mb-3">
                <i class="fas fa-paper-plane me-2"></i> Resend Verification Email
            </button>
        </form>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</div>
@endsection