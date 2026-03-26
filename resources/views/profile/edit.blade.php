@extends($layout)
@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile')

@push('styles')
<style>
    .profile-section {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }
    .profile-section-header {
        padding: 16px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .profile-section-body {
        padding: 24px;
    }
    .profile-photo-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 16px;
    }
    .profile-photo-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #e2e8f0;
    }
    .profile-photo-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #fff;
        font-weight: 700;
    }
    .form-label-custom {
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
        font-size: 14px;
    }

    {{-- Freelancer-only styles --}}
    @if($user->isFreelancer())
    .photo-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #6366f1;
        color: #fff;
        border: 3px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }
    .photo-upload-btn:hover {
        background: #4f46e5;
        transform: scale(1.1);
    }
    .skill-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        background: #eef2ff;
        color: #4338ca;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        margin: 4px;
    }
    .skill-tag .remove-skill {
        cursor: pointer;
        color: #dc2626;
        font-size: 12px;
        opacity: 0.6;
        transition: opacity 0.2s;
    }
    .skill-tag .remove-skill:hover {
        opacity: 1;
    }
    .experience-card, .education-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        transition: all 0.2s;
    }
    .experience-card:hover, .education-card:hover {
        border-color: #6366f1;
        box-shadow: 0 2px 8px rgba(99,102,241,0.1);
    }
    .completeness-bar {
        height: 10px;
        border-radius: 5px;
        background: #f1f5f9;
        overflow: hidden;
    }
    .completeness-fill {
        height: 100%;
        border-radius: 5px;
        transition: width 0.5s ease;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .portfolio-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 16px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 8px;
    }
    .resume-box {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    @endif
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

    <div class="row g-4">
        {{-- ════════════════════════════════════════════ --}}
        {{-- LEFT COLUMN --}}
        {{-- ════════════════════════════════════════════ --}}
        <div class="col-lg-8">

            {{-- ── 1. Profile Information (ALL ROLES) ── --}}
            <div class="profile-section">
                <div class="profile-section-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i> Profile Information</h5>
                </div>
                <div class="profile-section-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @if(!$user->hasVerifiedEmail())
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i> Not verified.
                                        <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-link btn-sm p-0 text-primary">Resend</button>
                                        </form>
                                    </small>
                                @else
                                    <small class="text-success"><i class="fas fa-check-circle me-1"></i> Verified</small>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $user->phone) }}" placeholder="+91 XXXXX XXXXX">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Role</label>
                                <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                            </div>

                            {{-- ── Freelancer Only Fields ── --}}
                            @if($user->isFreelancer())
                                <div class="col-md-6">
                                    <label class="form-label-custom">Hourly Rate (₹)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" name="hourly_rate" step="0.01" min="0"
                                               class="form-control @error('hourly_rate') is-invalid @enderror"
                                               value="{{ old('hourly_rate', $user->hourly_rate) }}" placeholder="0.00">
                                    </div>
                                    @error('hourly_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Availability</label>
                                    <select name="availability" class="form-select @error('availability') is-invalid @enderror">
                                        <option value="">Select Availability</option>
                                        <option value="full_time" {{ old('availability', $user->availability) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                        <option value="part_time" {{ old('availability', $user->availability) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                    </select>
                                    @error('availability') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endif

                            <div class="col-12">
                                <label class="form-label-custom">Bio</label>
                                <textarea name="bio" rows="4" class="form-control @error('bio') is-invalid @enderror"
                                          placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════ --}}
            {{-- FREELANCER ONLY SECTIONS --}}
            {{-- ══════════════════════════════════════════════════ --}}
            @if($user->isFreelancer())

                {{-- ── 2. Skills ── --}}
                <div class="profile-section">
                    <div class="profile-section-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-tools me-2"></i> Skills</h5>
                    </div>
                    <div class="profile-section-body">
                        <div id="skillsContainer" class="mb-3">
                            @foreach($user->skills as $skill)
                                <span class="skill-tag" id="skill-{{ $skill->id }}">
                                    {{ $skill->skill_name }}
                                    <i class="fas fa-times remove-skill" onclick="removeSkill({{ $skill->id }})"></i>
                                </span>
                            @endforeach
                            @if($user->skills->isEmpty())
                                <p class="text-muted small mb-0" id="noSkillsText">No skills added yet.</p>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <input type="text" id="skillInput" class="form-control" placeholder="Type a skill (e.g., Laravel, React)"
                                   style="max-width:300px;" maxlength="100">
                            <button type="button" class="btn btn-primary" onclick="addSkill()">
                                <i class="fas fa-plus me-1"></i> Add
                            </button>
                        </div>
                        <div id="skillError" class="text-danger small mt-1" style="display:none;"></div>
                    </div>
                </div>

                {{-- ── 3. Work Experience ── --}}
                <div class="profile-section">
                    <div class="profile-section-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-briefcase me-2"></i> Work Experience</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
                            <i class="fas fa-plus me-1"></i> Add
                        </button>
                    </div>
                    <div class="profile-section-body">
                        @forelse($user->workExperiences as $exp)
                            <div class="experience-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $exp->position }}</h6>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-building me-1"></i> {{ $exp->company_name }}
                                            <span class="badge bg-light text-dark ms-2" style="font-size:11px;">{{ $exp->employment_type_label }}</span>
                                        </p>
                                        <small class="text-muted"><i class="fas fa-calendar me-1"></i> {{ $exp->duration }}</small>
                                        @if($exp->description)
                                            <p class="mt-2 mb-0 small text-muted">{{ $exp->description }}</p>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editExperience{{ $exp->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('profile.experience.destroy', $exp) }}" method="POST"
                                              onsubmit="return confirm('Remove this experience?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Edit Experience Modal --}}
                            <div class="modal fade" id="editExperience{{ $exp->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius:16px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Experience</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('profile.experience.update', $exp) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Company Name *</label>
                                                        <input type="text" name="company_name" class="form-control"
                                                               value="{{ $exp->company_name }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Position *</label>
                                                        <input type="text" name="position" class="form-control"
                                                               value="{{ $exp->position }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Employment Type *</label>
                                                        <select name="employment_type" class="form-select" required>
                                                            @foreach(['full_time'=>'Full Time','part_time'=>'Part Time','contract'=>'Contract','freelance'=>'Freelance','internship'=>'Internship','temporary'=>'Temporary'] as $val => $lbl)
                                                                <option value="{{ $val }}" {{ $exp->employment_type == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label-custom">Start Year *</label>
                                                        <input type="number" name="start_year" class="form-control"
                                                               value="{{ $exp->start_year }}" min="1950" max="{{ date('Y') }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label-custom">End Year</label>
                                                        <input type="number" name="end_year" class="form-control"
                                                               value="{{ $exp->end_year }}" min="1950" max="{{ date('Y') }}"
                                                               id="editEndYear{{ $exp->id }}" {{ $exp->is_current ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="is_current" value="1"
                                                                   id="editCurrent{{ $exp->id }}" {{ $exp->is_current ? 'checked' : '' }}
                                                                   onchange="document.getElementById('editEndYear{{ $exp->id }}').disabled = this.checked">
                                                            <label class="form-check-label" for="editCurrent{{ $exp->id }}">I currently work here</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label-custom">Description</label>
                                                        <textarea name="description" rows="3" class="form-control">{{ $exp->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3 mb-0">No work experience added yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ── 4. Education ── --}}
                <div class="profile-section">
                    <div class="profile-section-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-graduation-cap me-2"></i> Education</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEducationModal">
                            <i class="fas fa-plus me-1"></i> Add
                        </button>
                    </div>
                    <div class="profile-section-body">
                        @forelse($user->educations as $edu)
                            <div class="education-card">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $edu->degree }}</h6>
                                        <p class="text-muted mb-1">
                                            <i class="fas fa-university me-1"></i> {{ $edu->institution }}
                                        </p>
                                        <small class="text-muted"><i class="fas fa-calendar me-1"></i> {{ $edu->duration }}</small>
                                        @if($edu->grade)
                                            <small class="text-muted ms-2"><i class="fas fa-star me-1"></i> Grade: {{ $edu->grade }}</small>
                                        @endif
                                        @if($edu->description)
                                            <p class="mt-2 mb-0 small text-muted">{{ $edu->description }}</p>
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#editEducation{{ $edu->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('profile.education.destroy', $edu) }}" method="POST"
                                              onsubmit="return confirm('Remove this education?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Edit Education Modal --}}
                            <div class="modal fade" id="editEducation{{ $edu->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="border-radius:16px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Education</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('profile.education.update', $edu) }}">
                                            @csrf @method('PUT')
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">School / College *</label>
                                                        <input type="text" name="institution" class="form-control"
                                                               value="{{ $edu->institution }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Degree *</label>
                                                        <input type="text" name="degree" class="form-control"
                                                               value="{{ $edu->degree }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Start Month *</label>
                                                        <input type="month" name="start_month" class="form-control"
                                                               value="{{ $edu->start_month }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">End Month</label>
                                                        <input type="month" name="end_month" class="form-control"
                                                               value="{{ $edu->end_month }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label-custom">Grade</label>
                                                        <input type="text" name="grade" class="form-control"
                                                               value="{{ $edu->grade }}" placeholder="e.g., 8.5 CGPA">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label-custom">Description</label>
                                                        <textarea name="description" rows="3" class="form-control">{{ $edu->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center py-3 mb-0">No education added yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ── 5. Portfolio Links ── --}}
                <div class="profile-section">
                    <div class="profile-section-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-link me-2"></i> Portfolio Links</h5>
                    </div>
                    <div class="profile-section-body">
                        @foreach($user->portfolioLinks as $link)
                            <div class="portfolio-item">
                                <div>
                                    <span class="fw-semibold">{{ $link->title }}</span>
                                    <a href="{{ $link->url }}" target="_blank" class="ms-2 small text-primary">
                                        <i class="fas fa-external-link-alt me-1"></i>{{ Str::limit($link->url, 40) }}
                                    </a>
                                </div>
                                <form action="{{ route('profile.portfolio.destroy', $link) }}" method="POST"
                                      onsubmit="return confirm('Remove this link?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        @endforeach

                        <form method="POST" action="{{ route('profile.portfolio.store') }}" class="mt-3">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                           placeholder="Title (e.g., GitHub)" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                                           placeholder="https://..." required>
                                    @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-plus me-1"></i> Add
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ── 6. Resume ── --}}
                <div class="profile-section">
                    <div class="profile-section-header">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-file-pdf me-2"></i> Resume</h5>
                    </div>
                    <div class="profile-section-body">
                        @if($user->resume)
                            <div class="resume-box mb-3">
                                <div style="width:48px;height:48px;border-radius:10px;background:#fee2e2;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-file-pdf fa-lg" style="color:#dc2626;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="fw-semibold mb-0">Resume Uploaded</p>
                                    <small class="text-muted">{{ basename($user->resume) }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ $user->resume_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    <form action="{{ route('profile.resume.remove') }}" method="POST"
                                          onsubmit="return confirm('Remove resume?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.resume.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex gap-2 align-items-center">
                                <input type="file" name="resume" class="form-control @error('resume') is-invalid @enderror"
                                       accept=".pdf,.doc,.docx" style="max-width:400px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-1"></i> Upload
                                </button>
                            </div>
                            <small class="text-muted mt-1 d-block">PDF, DOC, DOCX • Max 5MB</small>
                            @error('resume') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </form>
                    </div>
                </div>

            @endif
            {{-- ══════════════════════════════════════════════════ --}}
            {{-- END FREELANCER ONLY SECTIONS --}}
            {{-- ══════════════════════════════════════════════════ --}}

            {{-- ── Change Password (ALL ROLES) ── --}}
            <div class="profile-section">
                <div class="profile-section-header">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-lock me-2"></i> Change Password</h5>
                </div>
                <div class="profile-section-body">
                    @if(session('password_success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-1"></i> {{ session('password_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label-custom">Current Password *</label>
                                <input type="password" name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">New Password *</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Confirm Password *</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-key me-2"></i> Change Password</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── Danger Zone (ALL ROLES) ── --}}
            <div class="profile-section" style="border:2px solid #fee2e2;">
                <div class="profile-section-header" style="background:#fef2f2;">
                    <h5 class="mb-0 fw-bold text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Danger Zone</h5>
                </div>
                <div class="profile-section-body">
                    <p class="text-muted">Once you delete your account, all data will be <strong>permanently removed</strong>.</p>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash me-2"></i> Delete My Account
                    </button>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════ --}}
        {{-- RIGHT COLUMN (SIDEBAR) --}}
        {{-- ════════════════════════════════════════════ --}}
        <div class="col-lg-4">

            {{-- ── Profile Summary (ALL ROLES) ── --}}
            <div class="profile-section">
                <div class="profile-section-body text-center">
                    <div class="profile-photo-container">
                        {{-- Freelancer: Photo with upload --}}
                        @if($user->isFreelancer())
                            @if($user->has_profile_photo)
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="profile-photo-img" id="profilePhotoImg">
                            @else
                                <div class="profile-photo-placeholder" id="profilePhotoPlaceholder">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <label class="photo-upload-btn" for="photoInput" title="Change Photo">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="photoInput" style="display:none;" accept="image/jpg,image/jpeg,image/png,image/webp">
                        @else
                            {{-- Admin & Employer: Just placeholder --}}
                            <div class="profile-photo-placeholder">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Freelancer: Remove photo button --}}
                    @if($user->isFreelancer() && $user->has_profile_photo)
                        <button type="button" class="btn btn-sm btn-outline-danger mb-3" id="removePhotoBtn">
                            <i class="fas fa-trash me-1"></i> Remove Photo
                        </button>
                    @endif

                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>

                    <hr class="my-3">

                    <div class="text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Phone</span>
                            <span class="small fw-semibold">{{ $user->phone ?? '—' }}</span>
                        </div>

                        {{-- Freelancer only sidebar info --}}
                        @if($user->isFreelancer())
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Hourly Rate</span>
                                <span class="small fw-semibold">{{ $user->hourly_rate ? '₹' . $user->hourly_rate : '—' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Availability</span>
                                <span class="small fw-semibold">{{ $user->availability_label }}</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Status</span>
                            @if($user->is_active)
                                <span class="badge-role badge-active" style="font-size:11px;">Active</span>
                            @else
                                <span class="badge-role badge-inactive" style="font-size:11px;">Inactive</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Member Since</span>
                            <span class="small fw-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════ --}}
            {{-- FREELANCER ONLY SIDEBAR --}}
            {{-- ══════════════════════════════════════ --}}
            @if($user->isFreelancer())

                {{-- ── Profile Completeness ── --}}
                <div class="profile-section">
                    <div class="profile-section-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0">Profile Completeness</h6>
                            <span class="fw-bold" style="color:{{ $user->profile_completeness_color }};">
                                {{ $user->profile_completeness }}%
                            </span>
                        </div>
                        <div class="completeness-bar">
                            <div class="completeness-fill" style="width:{{ $user->profile_completeness }}%;background:{{ $user->profile_completeness_color }};"></div>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">Complete your profile to increase visibility</small>
                            <ul class="list-unstyled mt-2 mb-0" style="font-size:13px;">
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
                </div>

                {{-- ── Profile Status ── --}}
                <div class="profile-section">
                    <div class="profile-section-body">
                        <h6 class="fw-bold mb-3">Profile Status</h6>
                        <div class="text-center mb-3">
                            <div class="status-badge" style="background:{{ $user->profile_status_color }}15;color:{{ $user->profile_status_color }};font-size:14px;padding:8px 20px;">
                                <i class="fas fa-{{ match($user->profile_status) {
                                    'draft' => 'edit',
                                    'under_review' => 'clock',
                                    'verified' => 'check-circle',
                                    'rejected' => 'times-circle',
                                    'suspended' => 'ban',
                                    default => 'question-circle'
                                } }}"></i>
                                {{ $user->profile_status_label }}
                            </div>
                        </div>

                        @if($user->isDraft())
                            <p class="text-muted small text-center mb-3">Submit your profile for review to get verified.</p>
                            <form method="POST" action="{{ route('profile.submit-review') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100"
                                        {{ $user->profile_completeness < 60 ? 'disabled' : '' }}>
                                    <i class="fas fa-paper-plane me-2"></i> Submit for Review
                                </button>
                            </form>
                            @if($user->profile_completeness < 60)
                                <small class="text-danger d-block text-center mt-2">
                                    Complete at least 60% of your profile to submit.
                                </small>
                            @endif
                        @elseif($user->isUnderReview())
                            <p class="text-muted small text-center">Your profile is being reviewed by our team.</p>
                        @elseif($user->isVerified())
                            <p class="text-success small text-center">Your profile has been verified! ✅</p>
                        @elseif($user->isRejected())
                            <p class="text-danger small text-center">Your profile was rejected. Please update and resubmit.</p>
                            <form method="POST" action="{{ route('profile.submit-review') }}">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-redo me-2"></i> Resubmit for Review
                                </button>
                            </form>
                        @elseif($user->isSuspended())
                            <p class="text-danger small text-center">Your profile has been suspended. Contact support.</p>
                        @endif
                    </div>
                </div>

            @endif
            {{-- ══════════════════════════════════════ --}}
            {{-- END FREELANCER ONLY SIDEBAR --}}
            {{-- ══════════════════════════════════════ --}}
        </div>
    </div>

    {{-- ════════════════════════════════════════════ --}}
    {{-- MODALS (FREELANCER ONLY) --}}
    {{-- ════════════════════════════════════════════ --}}
    @if($user->isFreelancer())

        {{-- Add Experience Modal --}}
        <div class="modal fade" id="addExperienceModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:16px;">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"><i class="fas fa-briefcase me-2"></i> Add Work Experience</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('profile.experience.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" class="form-control" placeholder="e.g., TCS" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Position <span class="text-danger">*</span></label>
                                    <input type="text" name="position" class="form-control" placeholder="e.g., Software Developer" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Employment Type <span class="text-danger">*</span></label>
                                    <select name="employment_type" class="form-select" required>
                                        <option value="">Select Type</option>
                                        <option value="full_time">Full Time</option>
                                        <option value="part_time">Part Time</option>
                                        <option value="contract">Contract</option>
                                        <option value="freelance">Freelance</option>
                                        <option value="internship">Internship</option>
                                        <option value="temporary">Temporary</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">Start Year <span class="text-danger">*</span></label>
                                    <input type="number" name="start_year" class="form-control" min="1950" max="{{ date('Y') }}"
                                           placeholder="{{ date('Y') }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-custom">End Year</label>
                                    <input type="number" name="end_year" class="form-control" min="1950" max="{{ date('Y') }}"
                                           id="addEndYear" placeholder="{{ date('Y') }}">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_current" value="1" id="addCurrentCheck"
                                               onchange="document.getElementById('addEndYear').disabled = this.checked">
                                        <label class="form-check-label" for="addCurrentCheck">I currently work here</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom">Description</label>
                                    <textarea name="description" rows="3" class="form-control"
                                              placeholder="Brief description of your role..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Experience</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add Education Modal --}}
        <div class="modal fade" id="addEducationModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:16px;">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"><i class="fas fa-graduation-cap me-2"></i> Add Education</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('profile.education.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">School / College <span class="text-danger">*</span></label>
                                    <input type="text" name="institution" class="form-control" placeholder="e.g., IIT Delhi" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Degree <span class="text-danger">*</span></label>
                                    <input type="text" name="degree" class="form-control" placeholder="e.g., B.Tech in CSE" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Start Month <span class="text-danger">*</span></label>
                                    <input type="month" name="start_month" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">End Month</label>
                                    <input type="month" name="end_month" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Grade</label>
                                    <input type="text" name="grade" class="form-control" placeholder="e.g., 8.5 CGPA / 85%">
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom">Description</label>
                                    <textarea name="description" rows="3" class="form-control"
                                              placeholder="Activities, achievements..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Education</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif

    {{-- Delete Account Modal (ALL ROLES) --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> Delete Account
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('profile.delete') }}">
                    @csrf @method('DELETE')
                    <div class="modal-body">
                        <p class="text-muted">Are you sure? This will permanently remove all your data.</p>
                        <div class="mb-3">
                            <label class="form-label-custom">Confirm Password</label>
                            <input type="password" name="delete_password"
                                   class="form-control @error('delete_password') is-invalid @enderror" required>
                            @error('delete_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash me-2"></i> Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->has('delete_password'))
        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
                });
            </script>
        @endpush
    @endif
@endsection

{{-- ════════════════════════════════════════════ --}}
{{-- SCRIPTS (FREELANCER ONLY) --}}
{{-- ════════════════════════════════════════════ --}}
@if($user->isFreelancer())
@push('scripts')
<script>
    // ── Profile Photo Upload ──
    document.getElementById('photoInput').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;

        const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            alert('Please upload JPG, JPEG, PNG, or WEBP only.');
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB.');
            return;
        }

        const formData = new FormData();
        formData.append('profile_photo', file);

        fetch('{{ route("profile.photo.upload") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(() => alert('Failed to upload photo.'));
    });

    // ── Remove Photo ──
    const removePhotoBtn = document.getElementById('removePhotoBtn');
    if (removePhotoBtn) {
        removePhotoBtn.addEventListener('click', function() {
            if (!confirm('Remove your profile photo?')) return;

            fetch('{{ route("profile.photo.remove") }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
            })
            .catch(() => alert('Failed to remove photo.'));
        });
    }

    // ── Skills (AJAX) ──
    function addSkill() {
        const input = document.getElementById('skillInput');
        const skillName = input.value.trim();
        const errorDiv = document.getElementById('skillError');

        if (!skillName) {
            errorDiv.textContent = 'Please enter a skill name.';
            errorDiv.style.display = 'block';
            return;
        }

        errorDiv.style.display = 'none';

        fetch('{{ route("profile.skills.add") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ skill_name: skillName }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('skillsContainer');
                const noSkillsText = document.getElementById('noSkillsText');
                if (noSkillsText) noSkillsText.remove();

                const tag = document.createElement('span');
                tag.className = 'skill-tag';
                tag.id = 'skill-' + data.skill.id;
                tag.innerHTML = `${data.skill.skill_name} <i class="fas fa-times remove-skill" onclick="removeSkill(${data.skill.id})"></i>`;
                container.appendChild(tag);
                input.value = '';
            } else {
                errorDiv.textContent = data.message;
                errorDiv.style.display = 'block';
            }
        })
        .catch(() => {
            errorDiv.textContent = 'Failed to add skill.';
            errorDiv.style.display = 'block';
        });
    }

    document.getElementById('skillInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addSkill();
        }
    });

    function removeSkill(id) {
        if (!confirm('Remove this skill?')) return;

        fetch('/profile/skills/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const el = document.getElementById('skill-' + id);
                if (el) el.remove();
            }
        })
        .catch(() => alert('Failed to remove skill.'));
    }
</script>
@endpush
@endif
