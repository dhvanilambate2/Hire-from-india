@extends('layouts.dashboard')

@section('title', $job->title)

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('freelancer.jobs.index') }}" class="btn btn-outline-secondary me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h4 class="fw-bold mb-0">Job Details</h4>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="data-table">
                <div class="p-4">
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge-work-type badge-{{ $job->work_type }}">{{ $job->work_type_label }}</span>
                        @if($job->isActive())
                            <span class="badge-role badge-active">Accepting Applications</span>
                        @else
                            <span class="badge-role" style="background:#f1f5f9;color:#64748b;">Closed</span>
                        @endif
                    </div>

                    <h2 class="fw-bold mb-3">{{ $job->title }}</h2>

                    {{-- Key Info Cards --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background:#f0fdf4;">
                                <small class="text-muted d-block"><i class="fas fa-money-bill-wave me-1"></i> Salary</small>
                                <span class="fw-bold text-success" style="font-size:16px;">
                                    {{ $job->formatted_salary }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background:#eef2ff;">
                                <small class="text-muted d-block"><i class="fas fa-clock me-1"></i> Hours/Week</small>
                                <span class="fw-bold" style="font-size:16px;">
                                    {{ $job->hours_per_week ? $job->hours_per_week . ' hours' : 'Flexible' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3" style="background:#fef3c7;">
                                <small class="text-muted d-block"><i class="fas fa-calendar me-1"></i> Posted</small>
                                <span class="fw-bold" style="font-size:16px;">
                                    {{ $job->post_date->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Overview (rendered HTML from CKEditor) --}}
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-file-alt me-2 text-primary"></i> Job Overview
                    </h5>
                    <div class="job-overview-content p-3 rounded-3" style="background:#f8fafc;">
                        {!! $job->overview !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            {{-- Employer Info --}}
            <div class="data-table mb-4">
                <div class="p-3 border-bottom"><h6 class="fw-bold mb-0">About the Employer</h6></div>
                <div class="p-3">
                    <div class="d-flex align-items-center mb-2">
                        <div style="width:45px;height:45px;border-radius:50%;background:#fef3c7;display:flex;align-items:center;justify-content:center;font-weight:700;color:#d97706;">
                            {{ strtoupper(substr($job->employer->name, 0, 1)) }}
                        </div>
                        <div class="ms-3">
                            <div class="fw-bold">{{ $job->employer->name }}</div>
                            <small class="text-muted">{{ $job->employer->email }}</small>
                        </div>
                    </div>
                    @if($job->employer->bio)
                        <p class="text-muted small mt-2 mb-0">{{ Str::limit($job->employer->bio, 100) }}</p>
                    @endif
                </div>
            </div>

            {{-- Apply Section --}}
            @if($hasApplied)
                <div class="data-table">
                    <div class="p-4 text-center">
                        @if($application->isPending())
                            <div style="width:60px;height:60px;border-radius:50%;background:#fef3c7;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-clock fa-xl" style="color:#d97706;"></i>
                            </div>
                            <h6 class="fw-bold">Application Pending</h6>
                            <p class="text-muted small">Your application is being reviewed.</p>
                            <form action="{{ route('freelancer.applications.withdraw', $application) }}" method="POST" class="mt-2"
                                  onsubmit="return confirm('Withdraw your application?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-undo me-1"></i> Withdraw
                                </button>
                            </form>
                        @elseif($application->isAccepted())
                            <div style="width:60px;height:60px;border-radius:50%;background:#dcfce7;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-check-circle fa-xl" style="color:#16a34a;"></i>
                            </div>
                            <h6 class="fw-bold text-success">Accepted! 🎉</h6>
                            <p class="text-muted small">Congratulations!</p>
                        @else
                            <div style="width:60px;height:60px;border-radius:50%;background:#fee2e2;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-times-circle fa-xl" style="color:#dc2626;"></i>
                            </div>
                            <h6 class="fw-bold text-danger">Rejected</h6>
                            <p class="text-muted small">Your application was not selected.</p>
                        @endif
                    </div>
                </div>
            @elseif($job->isActive())
                <div class="data-table">
                    <div class="p-3 border-bottom">
                        <h6 class="fw-bold mb-0"><i class="fas fa-paper-plane me-2"></i> Apply Now</h6>
                    </div>
                    <div class="p-3">
                        <form method="POST" action="{{ route('freelancer.jobs.apply', $job) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Cover Letter <span class="text-danger">*</span></label>
                                <textarea name="cover_letter" rows="5"
                                          class="form-control @error('cover_letter') is-invalid @enderror"
                                          placeholder="Why are you the best fit?" required>{{ old('cover_letter') }}</textarea>
                                @error('cover_letter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Expected Salary</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="expected_salary" step="0.01" min="0"
                                           class="form-control" value="{{ old('expected_salary') }}" placeholder="0.00">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane me-2"></i> Submit Application
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="data-table">
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-lock fa-2x mb-2"></i>
                        <p class="mb-0">This job is no longer accepting applications.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
