@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)
@section('page-title', 'User Details')

@push('styles')
<style>
    .detail-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        margin-bottom: 20px;
    }
    .detail-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .detail-card-body {
        padding: 20px;
    }
    .info-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        width: 180px;
        font-weight: 600;
        color: #64748b;
        font-size: 14px;
    }
    .info-value {
        flex: 1;
        font-size: 14px;
    }
    .skill-tag-view {
        display: inline-flex;
        padding: 4px 12px;
        background: #eef2ff;
        color: #4338ca;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
        margin: 2px;
    }
    .exp-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 10px;
    }
    .completeness-bar-lg {
        height: 12px;
        border-radius: 6px;
        background: #f1f5f9;
        overflow: hidden;
    }
    .completeness-fill-lg {
        height: 100%;
        border-radius: 6px;
        transition: width 0.5s;
    }
    .portfolio-link-item {
        padding: 8px 14px;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 6px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endpush

@section('content')
    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" style="border-radius:12px;">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" style="border-radius:12px;">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Back Button --}}
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row g-4">
        {{-- ═══════════════════════════════ --}}
        {{-- LEFT COLUMN --}}
        {{-- ═══════════════════════════════ --}}
        <div class="col-lg-8">

            {{-- 1. Basic Information --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-user me-2"></i> Basic Information</h5>
                </div>
                <div class="detail-card-body">
                    <div class="d-flex align-items-center mb-4">
                        @if($user->has_profile_photo)
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                 style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #e2e8f0;">
                        @else
                            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#667eea,#764ba2);display:flex;align-items:center;justify-content:center;font-size:32px;color:#fff;font-weight:700;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="ms-3">
                            <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                            <span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            <span class="badge ms-1" style="background:{{ $user->profile_status_color }}15;color:{{ $user->profile_status_color }};font-size:11px;padding:4px 10px;border-radius:12px;">
                                {{ $user->profile_status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">
                            {{ $user->email }}
                            @if($user->email_verified_at)
                                <span class="badge-role badge-verified ms-2" style="font-size:10px;">
                                    <i class="fas fa-check me-1"></i>Verified
                                </span>
                            @else
                                <span class="badge-role badge-unverified ms-2" style="font-size:10px;">
                                    <i class="fas fa-times me-1"></i>Unverified
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $user->phone ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Bio</div>
                        <div class="info-value">{{ $user->bio ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Hourly Rate</div>
                        <div class="info-value">{{ $user->hourly_rate ? '₹' . $user->hourly_rate . '/hr' : '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Availability</div>
                        <div class="info-value">{{ $user->availability_label }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Account Status</div>
                        <div class="info-value">
                            @if($user->is_active)
                                <span class="badge-role badge-active">Active</span>
                            @else
                                <span class="badge-role badge-inactive">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Registered On</div>
                        <div class="info-value">{{ $user->created_at->format('F d, Y - h:i A') }}</div>
                    </div>
                </div>
            </div>

            {{-- 2. Company Info (Employers Only) --}}
            @if($user->isEmployer())
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h5 class="fw-bold mb-0"><i class="fas fa-building me-2"></i> Company Information</h5>
                    </div>
                    <div class="detail-card-body">
                        @if($user->company)
                            <div class="d-flex align-items-center mb-3">
                                @if($user->company->has_logo)
                                    <img src="{{ $user->company->logo_url }}" alt=""
                                         style="width:60px;height:60px;border-radius:12px;object-fit:cover;border:2px solid #e2e8f0;">
                                @else
                                    <div style="width:60px;height:60px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#94a3b8;font-size:24px;">
                                        <i class="fas fa-building"></i>
                                    </div>
                                @endif
                                <div class="ms-3">
                                    <h6 class="fw-bold mb-0">{{ $user->company->company_name }}</h6>
                                </div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Company Email</div>
                                <div class="info-value">{{ $user->company->company_email ?? '—' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Company Phone</div>
                                <div class="info-value">{{ $user->company->company_phone ?? '—' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Company Address</div>
                                <div class="info-value">{{ $user->company->company_address ?? '—' }}</div>
                            </div>
                        @else
                            <p class="text-muted text-center py-3 mb-0">
                                <i class="fas fa-building me-1"></i> Company profile not created yet.
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            {{-- 3. Skills --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-tools me-2"></i> Skills ({{ $user->skills->count() }})</h5>
                </div>
                <div class="detail-card-body">
                    @if($user->skills->count() > 0)
                        @foreach($user->skills as $skill)
                            <span class="skill-tag-view">{{ $skill->skill_name }}</span>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-2 mb-0">No skills added.</p>
                    @endif
                </div>
            </div>

            {{-- 4. Work Experience --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-briefcase me-2"></i> Work Experience ({{ $user->workExperiences->count() }})</h5>
                </div>
                <div class="detail-card-body">
                    @forelse($user->workExperiences as $exp)
                        <div class="exp-card">
                            <h6 class="fw-bold mb-1">{{ $exp->position }}</h6>
                            <p class="text-muted mb-1" style="font-size:13px;">
                                <i class="fas fa-building me-1"></i> {{ $exp->company_name }}
                                <span class="badge bg-light text-dark ms-1" style="font-size:10px;">{{ $exp->employment_type_label }}</span>
                            </p>
                            <small class="text-muted"><i class="fas fa-calendar me-1"></i> {{ $exp->duration }}</small>
                            @if($exp->description)
                                <p class="mt-2 mb-0 small text-muted">{{ $exp->description }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-2 mb-0">No work experience added.</p>
                    @endforelse
                </div>
            </div>

            {{-- 5. Education --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-graduation-cap me-2"></i> Education ({{ $user->educations->count() }})</h5>
                </div>
                <div class="detail-card-body">
                    @forelse($user->educations as $edu)
                        <div class="exp-card">
                            <h6 class="fw-bold mb-1">{{ $edu->degree }}</h6>
                            <p class="text-muted mb-1" style="font-size:13px;">
                                <i class="fas fa-university me-1"></i> {{ $edu->institution }}
                            </p>
                            <small class="text-muted"><i class="fas fa-calendar me-1"></i> {{ $edu->duration }}</small>
                            @if($edu->grade)
                                <small class="text-muted ms-2"><i class="fas fa-star me-1"></i> {{ $edu->grade }}</small>
                            @endif
                            @if($edu->description)
                                <p class="mt-2 mb-0 small text-muted">{{ $edu->description }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-2 mb-0">No education added.</p>
                    @endforelse
                </div>
            </div>

            {{-- 6. Portfolio Links --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-link me-2"></i> Portfolio Links ({{ $user->portfolioLinks->count() }})</h5>
                </div>
                <div class="detail-card-body">
                    @forelse($user->portfolioLinks as $link)
                        <div class="portfolio-link-item">
                            <span class="fw-semibold" style="font-size:13px;">{{ $link->title }}</span>
                            <a href="{{ $link->url }}" target="_blank" class="small text-primary">
                                <i class="fas fa-external-link-alt me-1"></i> {{ Str::limit($link->url, 40) }}
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center py-2 mb-0">No portfolio links added.</p>
                    @endforelse
                </div>
            </div>

            {{-- 7. Resume --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-file-pdf me-2"></i> Resume</h5>
                </div>
                <div class="detail-card-body">
                    @if($user->resume)
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:48px;height:48px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-file-pdf fa-lg" style="color:#dc2626;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="fw-semibold mb-0" style="font-size:14px;">{{ basename($user->resume) }}</p>
                            </div>
                            <a href="{{ $user->resume_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> View
                            </a>
                            <a href="{{ $user->resume_url }}" download class="btn btn-sm btn-outline-success">
                                <i class="fas fa-download me-1"></i> Download
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center py-2 mb-0">No resume uploaded.</p>
                    @endif
                </div>
            </div>

            {{-- 8. Recent Jobs (Employer) --}}
            @if($user->isEmployer() && $user->jobPosts->count() > 0)
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h5 class="fw-bold mb-0"><i class="fas fa-briefcase me-2"></i> Recent Job Posts</h5>
                    </div>
                    <div class="detail-card-body">
                        @foreach($user->jobPosts as $job)
                            <div class="exp-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $job->title }}</h6>
                                        <span class="badge-work-type badge-{{ $job->work_type }}" style="font-size:10px;">{{ $job->work_type_label }}</span>
                                        <small class="text-muted ms-2">{{ $job->formatted_salary }}</small>
                                    </div>
                                    <div>
                                        @if($job->isActive())
                                            <span class="badge-role badge-active" style="font-size:10px;">Active</span>
                                        @elseif($job->isBlocked())
                                            <span class="badge-role badge-inactive" style="font-size:10px;">Blocked</span>
                                        @else
                                            <span class="badge" style="background:#f1f5f9;color:#64748b;font-size:10px;padding:3px 8px;border-radius:8px;">Closed</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 9. Recent Applications (Freelancer) --}}
            @if($user->isFreelancer() && $user->jobApplications->count() > 0)
                <div class="detail-card">
                    <div class="detail-card-header">
                        <h5 class="fw-bold mb-0"><i class="fas fa-paper-plane me-2"></i> Recent Applications</h5>
                    </div>
                    <div class="detail-card-body">
                        @foreach($user->jobApplications as $app)
                            <div class="exp-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $app->jobPost->title ?? 'Deleted Job' }}</h6>
                                        <small class="text-muted">Applied {{ $app->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span class="badge" style="
                                        background: {{ match($app->status) {
                                            'pending' => '#fef3c7',
                                            'accepted' => '#dcfce7',
                                            'rejected' => '#fee2e2',
                                            default => '#f1f5f9'
                                        } }};
                                        color: {{ match($app->status) {
                                            'pending' => '#d97706',
                                            'accepted' => '#16a34a',
                                            'rejected' => '#dc2626',
                                            default => '#64748b'
                                        } }};
                                        font-size:11px;padding:4px 10px;border-radius:12px;">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- ═══════════════════════════════ --}}
        {{-- RIGHT COLUMN (SIDEBAR) --}}
        {{-- ═══════════════════════════════ --}}
        <div class="col-lg-4">

            {{-- Profile Completeness --}}
            <div class="detail-card">
                <div class="detail-card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-bold mb-0">Profile Completeness</h6>
                        <span class="fw-bold" style="color:{{ $user->profile_completeness_color }};font-size:18px;">
                            {{ $user->profile_completeness }}%
                        </span>
                    </div>
                    <div class="completeness-bar-lg">
                        <div class="completeness-fill-lg" style="width:{{ $user->profile_completeness }}%;background:{{ $user->profile_completeness_color }};"></div>
                    </div>
                    <ul class="list-unstyled mt-3 mb-0" style="font-size:13px;">
                        <li class="{{ $user->name ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->name ? 'check-circle' : 'circle' }} me-1"></i> Name
                        </li>
                        <li class="{{ $user->phone ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->phone ? 'check-circle' : 'circle' }} me-1"></i> Phone
                        </li>
                        <li class="{{ $user->bio ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->bio ? 'check-circle' : 'circle' }} me-1"></i> Bio
                        </li>
                        <li class="{{ $user->profile_photo ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->profile_photo ? 'check-circle' : 'circle' }} me-1"></i> Profile Photo
                        </li>
                        <li class="{{ $user->hourly_rate ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->hourly_rate ? 'check-circle' : 'circle' }} me-1"></i> Hourly Rate
                        </li>
                        <li class="{{ $user->availability ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->availability ? 'check-circle' : 'circle' }} me-1"></i> Availability
                        </li>
                        <li class="{{ $user->resume ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->resume ? 'check-circle' : 'circle' }} me-1"></i> Resume
                        </li>
                        <li class="{{ $user->skills->count() > 0 ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->skills->count() > 0 ? 'check-circle' : 'circle' }} me-1"></i> Skills
                        </li>
                        <li class="{{ $user->workExperiences->count() > 0 ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->workExperiences->count() > 0 ? 'check-circle' : 'circle' }} me-1"></i> Experience
                        </li>
                        <li class="{{ $user->educations->count() > 0 ? 'text-success' : 'text-muted' }}">
                            <i class="fas fa-{{ $user->educations->count() > 0 ? 'check-circle' : 'circle' }} me-1"></i> Education
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Profile Status Management --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h6 class="fw-bold mb-0">Profile Status</h6>
                </div>
                <div class="detail-card-body">
                    <div class="text-center mb-3">
                        <div class="badge" style="background:{{ $user->profile_status_color }}15;color:{{ $user->profile_status_color }};font-size:14px;padding:8px 20px;border-radius:12px;">
                            <i class="fas fa-{{ match($user->profile_status) {
                                'draft' => 'edit',
                                'under_review' => 'clock',
                                'verified' => 'check-circle',
                                'rejected' => 'times-circle',
                                'suspended' => 'ban',
                                default => 'question-circle'
                            } }} me-1"></i>
                            {{ $user->profile_status_label }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.users.profile-status', $user) }}">
                        @csrf @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:13px;">Change Profile Status</label>
                            <select name="profile_status" class="form-select form-select-sm">
                                <option value="draft" {{ $user->profile_status == 'draft' ? 'selected' : '' }}>
                                    📝 Draft
                                </option>
                                <option value="under_review" {{ $user->profile_status == 'under_review' ? 'selected' : '' }}>
                                    ⏳ Under Review
                                </option>
                                <option value="verified" {{ $user->profile_status == 'verified' ? 'selected' : '' }}>
                                    ✅ Verified
                                </option>
                                <option value="rejected" {{ $user->profile_status == 'rejected' ? 'selected' : '' }}>
                                    ❌ Rejected
                                </option>
                                <option value="suspended" {{ $user->profile_status == 'suspended' ? 'selected' : '' }}>
                                    🚫 Suspended
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-save me-1"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h6 class="fw-bold mb-0">Quick Actions</h6>
                </div>
                <div class="detail-card-body">
                    <div class="d-grid gap-2">
                        {{-- Verify Button --}}
                        @if($user->profile_status !== 'verified')
                            <form action="{{ route('admin.users.profile-status', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="profile_status" value="verified">
                                <button class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-check-circle me-1"></i> Verify Profile
                                </button>
                            </form>
                        @endif

                        {{-- Reject Button --}}
                        @if($user->profile_status !== 'rejected')
                            <form action="{{ route('admin.users.profile-status', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="profile_status" value="rejected">
                                <button class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Reject this profile?')">
                                    <i class="fas fa-times-circle me-1"></i> Reject Profile
                                </button>
                            </form>
                        @endif

                        {{-- Suspend Button --}}
                        @if($user->profile_status !== 'suspended')
                            <form action="{{ route('admin.users.profile-status', $user) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="profile_status" value="suspended">
                                <button class="btn btn-warning btn-sm w-100"
                                        onclick="return confirm('Suspend this profile?')">
                                    <i class="fas fa-ban me-1"></i> Suspend Profile
                                </button>
                            </form>
                        @endif

                        <hr class="my-1">

                        {{-- Toggle Account Status --}}
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="btn btn-{{ $user->is_active ? 'outline-warning' : 'outline-success' }} btn-sm w-100">
                                <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }} me-1"></i>
                                {{ $user->is_active ? 'Deactivate Account' : 'Activate Account' }}
                            </button>
                        </form>

                        {{-- Delete --}}
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                              onsubmit="return confirm('Delete this user permanently? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash me-1"></i> Delete User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
