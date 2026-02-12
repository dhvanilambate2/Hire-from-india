@extends('layouts.app')

@section('body')
    {{-- Simple top navbar for freelancer/employer --}}
    <nav class="navbar navbar-expand-lg" style="background:#fff;box-shadow:0 1px 3px rgba(0,0,0,0.05);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-bolt" style="color:#4f46e5;"></i>
                Freelancer Platform
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->isFreelancer())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('freelancer.dashboard') ? 'active fw-bold' : '' }}"
                               href="{{ route('freelancer.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->isEmployer())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('employer.dashboard') ? 'active fw-bold' : '' }}"
                               href="{{ route('employer.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active fw-bold' : '' }}"
                           href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-edit me-1"></i> Edit Profile
                        </a>
                    </li>
                </ul>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                        <span class="badge-role badge-{{ auth()->user()->role }} ms-1" style="font-size:10px;">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit me-2"></i> Edit Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
@endsection
