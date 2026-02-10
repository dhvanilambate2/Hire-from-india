@extends('layouts.guest')

@section('content')

    <!-- Info Text -->
    <p class="text-muted mb-4">
        {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
    </p>

    <!-- Status Message -->
    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success mb-4">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center">
        <!-- Resend Verification -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

@endsection
