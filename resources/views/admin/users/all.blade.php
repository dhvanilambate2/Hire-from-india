{{-- resources/views/admin/users/all.blade.php --}}

@extends('layouts.admin')

@section('title', 'All Users')
@section('page-title', 'All Users')

@section('content')
    {{-- Filters --}}
    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="freelancer" {{ request('role') == 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                        <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>Employer</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="data-table">
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-users me-2"></i> Users ({{ $users->total() }})
            </h5>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Email Verified</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            <span class="badge-role badge-{{ $user->role }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge-role badge-verified">
                                    <i class="fas fa-check me-1"></i> Verified
                                </span>
                            @else
                                <span class="badge-role badge-unverified">
                                    <i class="fas fa-times me-1"></i> Unverified
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge-role badge-active">Active</span>
                            @else
                                <span class="badge-role badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                            title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i> No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div class="p-3">
                {{ $users->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection