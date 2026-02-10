@extends('layouts.guest')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">{{ __('Name') }}</label>
        <input id="name" type="text"
               class="form-control @error('name') is-invalid @enderror"
               name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">{{ __('Email') }}</label>
        <input id="email" type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email" value="{{ old('email') }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Role -->
    <div class="mb-3">
        <label for="role" class="form-label">{{ __('Register As') }}</label>
        <select id="role" name="role"
                class="form-select @error('role') is-invalid @enderror">
            <option value="">Select role</option>
            <option value="freelancer" {{ old('role') == 'freelancer' ? 'selected' : '' }}>
                Freelancer
            </option>
            <option value="employer" {{ old('role') == 'employer' ? 'selected' : '' }}>
                Employer
            </option>
        </select>
        @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">{{ __('Password') }}</label>
        <input id="password" type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password" required autocomplete="new-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">
            {{ __('Confirm Password') }}
        </label>
        <input id="password_confirmation" type="password"
               class="form-control"
               name="password_confirmation" required autocomplete="new-password">
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('login') }}" class="text-decoration-none">
            {{ __('Already registered?') }}
        </a>

        <button type="submit" class="btn btn-primary">
            {{ __('Register') }}
        </button>
    </div>
</form>
@endsection
