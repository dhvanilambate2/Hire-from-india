@extends('layouts.app')

@section('body')
    {{-- Sidebar --}}
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-bolt"></i> Admin Panel
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            <li class="menu-header">Job Management</li>
            <li>
                <a href="{{ route('admin.jobs.index') }}"
                class="{{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i> All Job Posts
                </a>
            </li>
            
            <li class="menu-header">User Management</li>
            <li>
                <a href="{{ route('admin.users.all') }}"
                   class="{{ request()->routeIs('admin.users.all') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> All Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.freelancers') }}"
                   class="{{ request()->routeIs('admin.users.freelancers') ? 'active' : '' }}">
                    <i class="fas fa-laptop-code"></i> Freelancers
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.employers') }}"
                   class="{{ request()->routeIs('admin.users.employers') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Employers
                </a>
            </li>

            <li class="menu-header">Admin Management</li>
            <li>
                <a href="{{ route('admin.admins.index') }}"
                   class="{{ request()->routeIs('admin.admins.index') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i> All Admins
                </a>
            </li>
            <li>
                <a href="{{ route('admin.admins.create') }}"
                   class="{{ request()->routeIs('admin.admins.create') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i> Create Admin
                </a>
            </li>

            <li class="menu-header">Account</li>
            <li>
                <a href="{{ route('profile.edit') }}"
                   class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
            </li>
        </ul>
    </nav>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Top Navbar --}}
        <div class="top-navbar">
            <div>
                <button class="btn btn-sm btn-outline-secondary d-md-none"
                        onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="fw-bold ms-2">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="dropdown user-dropdown">
                <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                    <li><hr class="dropdown-divider"></li>
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

        {{-- Content --}}
        <div class="content-area">
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
    </div>
@endsection
