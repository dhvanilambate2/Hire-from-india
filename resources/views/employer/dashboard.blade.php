{{-- resources/views/employer/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body p-5 text-center">
                    <div style="width:80px;height:80px;border-radius:50%;background:#fef3c7;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-building fa-2x" style="color:#d97706;"></i>
                    </div>
                    <h3 class="fw-bold">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="text-muted">You are logged in as an <strong>Employer</strong>.</p>
                    <span class="badge-role badge-employer mb-4 d-inline-block">Employer Account</span>

                    <hr>
                    <p class="text-muted">Your employer dashboard features will go here.</p>

                    <form action="{{ route('logout') }}" method="POST" class="mt-3">
                        @csrf
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection