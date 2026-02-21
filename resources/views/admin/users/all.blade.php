@extends('layouts.admin')

@section('title', 'All Users')
@section('page-title', 'All Users')

@section('content')
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filters --}}
    <div class="data-table mb-4">
        <div class="p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="search" class="form-control"
                           placeholder="Name or email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Role</label>
                    <select name="role" class="form-select">
                        <option value="">All Roles</option>
                        <option value="freelancer" {{ request('role') == 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                        <option value="employer" {{ request('role') == 'employer' ? 'selected' : '' }}>Employer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Profile Status</label>
                    <select name="profile_status" class="form-select">
                        <option value="">All Profile Status</option>
                        <option value="draft" {{ request('profile_status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="under_review" {{ request('profile_status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                        <option value="verified" {{ request('profile_status') == 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('profile_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="suspended" {{ request('profile_status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
            @if(request()->hasAny(['search', 'role', 'status', 'profile_status']))
                <div class="mt-2">
                    <a href="{{ route('admin.users.all') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Bulk Actions --}}
    <div class="data-table mb-3" id="bulkActions" style="display:none;">
        <div class="p-3 d-flex align-items-center gap-3" style="background:#eef2ff;border-radius:12px;">
            <span class="fw-semibold" id="selectedCount">0 selected</span>
            <form method="POST" action="{{ route('admin.users.bulk-status') }}" class="d-flex gap-2" id="bulkForm">
                @csrf
                <div id="bulkUserIds"></div>
                <select name="profile_status" class="form-select form-select-sm" style="width:180px;" required>
                    <option value="">Change Status To</option>
                    <option value="draft">Draft</option>
                    <option value="under_review">Under Review</option>
                    <option value="verified">Verified</option>
                    <option value="rejected">Rejected</option>
                    <option value="suspended">Suspended</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">Apply</button>
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
                    <th><input type="checkbox" id="selectAll" onchange="toggleSelectAll()"></th>
                    <th>#</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Profile Status</th>
                    <th>Completeness</th>
                    <th>Email Verified</th>
                    <th>Account</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox" class="user-checkbox" value="{{ $user->id }}"
                                   onchange="updateBulkActions()">
                        </td>
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
                            <span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            <span class="badge" style="background:{{ $user->profile_status_color }}15;color:{{ $user->profile_status_color }};font-size:11px;padding:4px 10px;border-radius:12px;">
                                <i class="fas fa-{{ match($user->profile_status) {
                                    'draft' => 'edit',
                                    'under_review' => 'clock',
                                    'verified' => 'check-circle',
                                    'rejected' => 'times-circle',
                                    'suspended' => 'ban',
                                    default => 'question-circle'
                                } }} me-1"></i>
                                {{ $user->profile_status_label }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:50px;height:6px;border-radius:3px;background:#f1f5f9;overflow:hidden;">
                                    <div style="width:{{ $user->profile_completeness }}%;height:100%;background:{{ $user->profile_completeness_color }};border-radius:3px;"></div>
                                </div>
                                <small class="fw-semibold" style="color:{{ $user->profile_completeness_color }};">
                                    {{ $user->profile_completeness }}%
                                </small>
                            </div>
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge-role badge-verified"><i class="fas fa-check me-1"></i>Yes</span>
                            @else
                                <span class="badge-role badge-unverified"><i class="fas fa-times me-1"></i>No</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge-role badge-active">Active</span>
                            @else
                                <span class="badge-role badge-inactive">Inactive</span>
                            @endif
                        </td>
                        <td style="font-size:13px;">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                            title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                      onsubmit="return confirm('Delete this user permanently?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i> No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
            <div class="p-3">{{ $users->withQueryString()->links() }}</div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function toggleSelectAll() {
        const checked = document.getElementById('selectAll').checked;
        document.querySelectorAll('.user-checkbox').forEach(cb => cb.checked = checked);
        updateBulkActions();
    }

    function updateBulkActions() {
        const checked = document.querySelectorAll('.user-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        const bulkUserIds = document.getElementById('bulkUserIds');

        if (checked.length > 0) {
            bulkActions.style.display = 'block';
            selectedCount.textContent = checked.length + ' selected';
            bulkUserIds.innerHTML = '';
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'user_ids[]';
                input.value = cb.value;
                bulkUserIds.appendChild(input);
            });
        } else {
            bulkActions.style.display = 'none';
        }
    }
</script>
@endpush
