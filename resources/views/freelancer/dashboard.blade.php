{{-- resources/views/freelancer/dashboard.blade.php --}}

@extends('layouts.app')

@section('title', 'Freelancer Dashboard')

@section('body')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius:16px;">
                <div class="card-body p-5 text-center">
                    <div style="width:80px;height:80px;border-radius:50%;background:#dbeafe;margin:0 auto 20px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-laptop-code fa-2x" style="color:#2563eb;"></i>
                    </div>
                    <h3 class="fw-bold">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="text-muted">You are logged in as a <strong>Freelancer</strong>.</p>
                    <span class="badge-role badge-freelancer mb-4 d-inline-block">Freelancer Account</span>

                    <hr>
                    <p class="text-muted">Your freelancer dashboard features will go here.</p>

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