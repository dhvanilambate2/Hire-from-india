@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- Page Title -->
    <div class="mb-4">
        <h1 class="h4">
            {{ __('Profile') }}
        </h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Profile Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
