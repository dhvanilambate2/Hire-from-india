@extends('layouts.dashboard')

@section('title', 'Employer Dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="data-table">
                <div class="p-5 text-center">
                    <div style="width:80px;height:80px;border-radius:50%;background:#fef3c7;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-building fa-2x" style="color:#d97706;"></i>
                    </div>
                    <h3 class="fw-bold">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="text-muted">You are logged in as an <strong>Employer</strong>.</p>
                    <span class="badge-role badge-employer mb-4 d-inline-block">Employer Account</span>
                    <hr>
                    <p class="text-muted">Your employer dashboard features will go here.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-user-edit me-2"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
