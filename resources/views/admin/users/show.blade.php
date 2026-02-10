{{-- resources/views/admin/users/show.blade.php --}}

@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="data-table">
                <div class="p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div style="width:70px;height:70px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;font-size:28px;color:#4f46e5;font-weight:700;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0 fw-bold">{{ $user->name }}</h4>
                            <span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold text-muted" style="width:200px;">Email</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Phone</td>
                            <td>{{ $user->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Bio</td>
                            <td>{{ $user->bio ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Email Verified</td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge-role badge-verified">
                                        <i class="fas fa-check me-1"></i>Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="badge-role badge-unverified">
                                        <i class="fas fa-times me-1"></i>Not Verified
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Account Status</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge-role badge-active">Active</span>
                                @else
                                    <span class="badge-role badge-inactive">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted">Registered On</td>
                            <td>{{ $user->created_at->format('F d, Y - h:i A') }}</td>
                        </tr>
                    </table>

                    <div class="d-flex gap-2 mt-3">
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-{{ $user->is_active ? 'warning' : 'success' }}">
                                <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }} me-1"></i>
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Delete this user permanently?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Delete User
                            </button>
                        </form>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection