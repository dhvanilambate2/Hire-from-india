@extends('layouts.admin')

@section('title', 'Freelancers')
@section('page-title', 'Freelancers')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="profile_status" class="form-select">
                        <option value="">All Profile Status</option>
                        <option value="draft" {{ request('profile_status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="under_review" {{ request('profile_status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="verified" {{ request('profile_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('profile_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="suspended" {{ request('profile_status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('admin.users.freelancers') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="data-table">
        <div class="p-3 border-bottom">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-user-tie me-2"></i> Freelancers ({{ $freelancers->total() }})
            </h5>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Freelancer</th>
                    <th>Skills</th>
                    <th>Rate</th>
                    <th>Availability</th>
                    <th>Profile Status</th>
                    <th>Completeness</th>
                    <th>Account</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($freelancers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->has_profile_photo)
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                         style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0;">
                                @else
                                    <div style="width:36px;height:36px;border-radius:50%;background:#eef2ff;display:flex;align-items:center;justify-content:center;font-weight:700;color:#4f46e5;font-size:14px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold" style="font-size:14px;">{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info rounded-pill">{{ $user->skills_count }}</span>
                        </td>
                        <td>
                            <span style="font-size:13px;">{{ $user->hourly_rate ? '₹' . $user->hourly_rate . '/hr' : '—' }}</span>
                        </td>
                        <td>
                            @if($user->availability)
                                <span class="badge" style="background:#f0fdf4;color:#16a34a;font-size:11px;padding:4px 10px;border-radius:12px;">
                                    {{ $user->availability_label }}
                                </span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="background:{{ $user->profile_status_color }}15;color:{{ $user->profile_status_color }};font-size:11px;padding:4px 10px;border-radius:12px;">
                                {{ $user->profile_status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:40px;height:6px;border-radius:3px;background:#f1f5f9;overflow:hidden;">
                                    <div style="width:{{ $user->profile_completeness }}%;height:100%;background:{{ $user->profile_completeness_color }};border-radius:3px;"></div>
                                </div>
                                <small class="fw-semibold" style="color:{{ $user->profile_completeness_color }};">{{ $user->profile_completeness }}%</small>
                            </div>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge-role badge-active">Active</span>
                            @else
                                <span class="badge-role badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Delete this freelancer?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">No freelancers found</td></tr>
                @endforelse
            </tbody>
        </table>
        @if($freelancers->hasPages())
            <div class="p-3">{{ $freelancers->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection
