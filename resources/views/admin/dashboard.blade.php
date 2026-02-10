{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Stats Row --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['total_users'] }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-icon" style="background:#eef2ff;color:#4f46e5;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['total_freelancers'] }}</div>
                        <div class="stat-label">Freelancers</div>
                    </div>
                    <div class="stat-icon" style="background:#dbeafe;color:#2563eb;">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['total_employers'] }}</div>
                        <div class="stat-label">Employers</div>
                    </div>
                    <div class="stat-icon" style="background:#fef3c7;color:#d97706;">
                        <i class="fas fa-building"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['total_admins'] }}</div>
                        <div class="stat-label">Admins</div>
                    </div>
                    <div class="stat-icon" style="background:#ede9fe;color:#7c3aed;">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['verified_users'] }}</div>
                        <div class="stat-label">Verified</div>
                    </div>
                    <div class="stat-icon" style="background:#dcfce7;color:#16a34a;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-number">{{ $stats['unverified_users'] }}</div>
                        <div class="stat-label">Unverified</div>
                    </div>
                    <div class="stat-icon" style="background:#fee2e2;color:#dc2626;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="data-table">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0 fw-bold">Recent Users</h5>
            <a href="{{ route('admin.users.all') }}" class="btn btn-sm btn-outline-primary">View All</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentUsers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge-role badge-{{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge-role badge-active">Active</span>
                            @else
                                <span class="badge-role badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection